<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Lista TODAS as inscrições (apenas para Admin/Organizer)
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin vê TODAS as inscrições
            $registrations = Registration::with(['user', 'event'])->latest()->paginate(15);
        } else {
            // Organizador vê apenas inscrições dos SEUS eventos
            $registrations = Registration::with(['user', 'event'])
                ->whereHas('event', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(15);
        }

        return view('registrations.index', compact('registrations'));
    }

    /**
     * Lista as MINHAS inscrições (para Participant)
     */
    public function myRegistrations()
    {
        $registrations = Registration::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('registrations.my-registrations', compact('registrations'));
    }

    /**
     * Inscrever-se num evento
     */
    public function register(Event $event)
    {
        $user = Auth::user();

        // Validações
        if ($event->user_id === $user->id) {
            return back()->with('error', 'Não podes inscrever-te no teu próprio evento!');
        }

        // Verificar se já está inscrito
        $alreadyRegistered = Registration::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Já estás inscrito neste evento!');
        }

        // Verificar se há vagas
        $currentRegistrations = Registration::where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->count();

        if ($currentRegistrations >= $event->max_participants) {
            return back()->with('error', 'Este evento já atingiu o número máximo de participantes!');
        }

        // Criar inscrição
        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'confirmed',
            'registration_date' => now(),
        ]);

        return back()->with('success', 'Inscrição realizada com sucesso!');
    }

    /**
     * Cancelar inscrição
     */
    public function cancel(Registration $registration)
    {
        $user = Auth::user();

        // Verificar se a inscrição pertence ao utilizador
        if ($registration->user_id !== $user->id && $user->role !== 'admin') {
            return back()->with('error', 'Não tens permissão para cancelar esta inscrição!');
        }

        // Verificar se o evento já passou
        if ($registration->event->date < now()) {
            return back()->with('error', 'Não podes cancelar inscrição de um evento que já passou!');
        }

        $registration->delete();

        return back()->with('success', 'Inscrição cancelada com sucesso!');
    }

    /**
     * Alterar status da inscrição (apenas Admin/Organizer)
     */
    public function updateStatus(Registration $registration, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $user = Auth::user();

        // Verificar permissões
        if ($user->role === 'organizer' && $registration->event->user_id !== $user->id) {
            return back()->with('error', 'Não tens permissão para alterar esta inscrição!');
        }

        $registration->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status da inscrição atualizado!');
    }
}
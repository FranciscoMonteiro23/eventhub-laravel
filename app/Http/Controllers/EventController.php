<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ CORRETO: Retorna EVENTOS, não registrations!
        $events = Event::with(['category', 'user', 'registrations'])
            ->orderBy('start_date', 'desc')
            ->paginate(15);
        
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload da imagem (se existir)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        // Adicionar o user_id do criador
        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['category', 'user', 'registrations.user']);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Apenas o criador ou admin pode editar
        if (Auth::id() !== $event->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Não tens permissão para editar este evento.');
        }

        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Apenas o criador ou admin pode atualizar
        if (Auth::id() !== $event->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Não tens permissão para atualizar este evento.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload da nova imagem (se existir)
        if ($request->hasFile('image')) {
            // Apagar imagem antiga
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Apenas o criador ou admin pode apagar
        if (Auth::id() !== $event->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Não tens permissão para apagar este evento.');
        }

        // Apagar imagem se existir
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Evento apagado com sucesso!');
    }
}
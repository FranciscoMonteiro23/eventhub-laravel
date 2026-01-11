<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Homepage pública com lista de eventos
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'user'])
            ->where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc');

        // Filtro por categoria
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Pesquisa por nome
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por data
        if ($request->has('date') && $request->date != '') {
            $date = $request->date;
            
            switch($date) {
                case 'today':
                    $query->whereDate('start_date', today());
                    break;
                case 'week':
                    $query->whereBetween('start_date', [now(), now()->addWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('start_date', [now(), now()->addMonth()]);
                    break;
            }
        }

        $events = $query->paginate(12);
        $categories = Category::all();
        
        // Estatísticas para a homepage
        $stats = [
            'total_events' => Event::where('status', 'published')->where('start_date', '>', now())->count(),
            'total_categories' => Category::count(),
            'featured_events' => Event::where('is_featured', true)->where('status', 'published')->where('start_date', '>', now())->take(3)->get(),
        ];

        return view('public.index', compact('events', 'categories', 'stats'));
    }

    /**
     * Página de detalhes pública de um evento
     */
    public function show(Event $event)
    {
        $event->load(['category', 'user', 'registrations']);
        
        // Contador de participantes confirmados
        $confirmedCount = $event->registrations()->where('status', 'confirmed')->count();
        $availableSpots = $event->max_participants - $confirmedCount;

        return view('public.show', compact('event', 'confirmedCount', 'availableSpots'));
    }
}
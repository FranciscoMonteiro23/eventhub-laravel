<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'creator')->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required|min:20',
            'category_id' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'max_participants' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $event = new Event();
        $event->user_id = $request->user()->id;
        $event->category_id = $request->category_id;
        $event->title = $request->title;
        $event->slug = Str::slug($request->title);
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->max_participants = $request->max_participants;
        $event->price = $request->price;
        $event->status = $request->status;
        $event->is_featured = $request->has('is_featured') ? 1 : 0;
        $event->save();

        return redirect()->route('events.index');
    }

    public function show(Event $event)
    {
        $event->load('category', 'creator', 'registrations.user');
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'max_participants' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $event->category_id = $request->category_id;
        $event->title = $request->title;
        $event->slug = Str::slug($request->title);
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->max_participants = $request->max_participants;
        $event->price = $request->price;
        $event->status = $request->status;
        $event->is_featured = $request->has('is_featured') ? 1 : 0;
        $event->save();

        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
  public function index()
  {
    $events = auth()->user()->events()->latest()->get();
    return view('user.events.index', compact('events'));
  }

  public function create(Request $request)
  {
    $category = $request->query('category');

    if (!$category || !in_array($category, ['wedding', 'birthday'])) {
      return view('user.events.choose_category');
    }

    $templates = EventTemplate::where('is_active', true)
      ->where('category', $category)
      ->get();

    return view('user.events.create', compact('templates', 'category'));
  }

  public function store(Request $request)
  {
    // Check Quota
    $user = auth()->user();
    if ($user->events()->count() >= $user->event_quota) {
      return back()->withErrors(['quota' => 'You have reached your event creation quota. Please contact admin to upgrade.'])->withInput();
    }
    $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'required|string|max:255|unique:events,slug',
      'event_date' => 'required|date',
      'event_template_id' => 'required|exists:event_templates,id',
      'whatsapp_message' => 'nullable|string',
      'category' => 'required|in:wedding,birthday',
    ]);

    $event = new Event();
    $event->user_id = auth()->id();
    $event->title = $request->title;
    $event->slug = Str::slug($request->slug);
    $event->event_date = $request->event_date;
    $event->event_template_id = $request->event_template_id;
    $event->whatsapp_message = $request->whatsapp_message;
    $event->category = $request->category;
    $event->save();

    // Initialize specific event details based on category
    if ($request->category === 'wedding') {
      \App\Models\WeddingEvent::create(['event_id' => $event->id]);
    } elseif ($request->category === 'birthday') {
      // Initialize BirthdayEvent with placeholders or defaults
      \App\Models\BirthdayEvent::create([
        'event_id' => $event->id,
        'person_name' => 'Birthday Person',
        'age' => 0
      ]);
    }

    return redirect()->route('user.events.index')->with('success', 'Event created successfully!');
  }

  public function show(Event $event)
  {
    // Check ownership
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }
    return view('user.events.show', compact('event'));
  }

  public function edit(Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }
    $templates = EventTemplate::where('is_active', true)->get();
    return view('user.events.edit', compact('event', 'templates'));
  }

  public function update(Request $request, Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'required|string|max:255|unique:events,slug,' . $event->id,
      'event_date' => 'required|date',
      'event_template_id' => 'required|exists:event_templates,id',
      'whatsapp_message' => 'nullable|string',
    ]);

    $event->title = $request->title;
    $event->slug = Str::slug($request->slug);
    $event->event_date = $request->event_date;
    $event->event_template_id = $request->event_template_id;
    $event->whatsapp_message = $request->whatsapp_message;
    $event->save();

    return redirect()->route('user.events.index')->with('success', 'Event updated successfully!');
  }

  public function destroy(Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }
    $event->delete();
    return redirect()->route('user.events.index')->with('success', 'Event deleted successfully!');
  }
}

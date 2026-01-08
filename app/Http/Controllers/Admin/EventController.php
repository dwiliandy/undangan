<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
  public function index()
  {
    $events = Event::with('user', 'template')->latest()->paginate(10);
    return view('admin.events.index', compact('events'));
  }

  public function destroy(Event $event)
  {
    $event->delete();
    return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
  }
}

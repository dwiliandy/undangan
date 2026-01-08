<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventContentController extends Controller
{
  public function index(Event $event)
  {
    // Load all necessary relationships for the dashboard
    $event->load(['weddingEvent', 'eventJourneys', 'eventGalleries', 'eventLocations']);

    return view('user.events.manage', compact('event'));
  }
}

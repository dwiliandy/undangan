<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventJourney;
use Illuminate\Http\Request;

class EventJourneyController extends Controller
{
  public function store(Request $request, Event $event)
  {
    $request->validate([
      'title' => 'required',
      'journey_date' => 'required|date',
      'description' => 'required',
    ]);

    $event->eventJourneys()->create($request->all());

    return back()->with('success', 'Journey added successfully.');
  }

  public function update(Request $request, Event $event, EventJourney $journey)
  {
    $request->validate([
      'title' => 'required',
      'journey_date' => 'required|date',
      'description' => 'required',
    ]);

    $journey->update($request->all());

    return back()->with('success', 'Journey updated successfully.');
  }

  public function destroy(Event $event, EventJourney $journey)
  {
    $journey->delete();
    return back()->with('success', 'Journey deleted successfully.');
  }
}

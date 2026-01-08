<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventLocation;
use Illuminate\Http\Request;

class EventLocationController extends Controller
{
  public function store(Request $request, Event $event)
  {
    $request->validate([
      'name' => 'required',
      'address' => 'required',
      'event_time' => 'required',
      'location_type' => 'required|in:akad,resepsi,party,online',
    ]);

    $event->eventLocations()->create($request->all());

    return back()->with('success', 'Location added successfully.');
  }

  public function update(Request $request, Event $event, EventLocation $location)
  {
    $request->validate([
      'name' => 'required',
      'address' => 'required',
      'event_time' => 'required',
      'location_type' => 'required|in:akad,resepsi,party,online',
    ]);

    $location->update($request->all());

    return back()->with('success', 'Location updated successfully.');
  }

  public function destroy(Event $event, EventLocation $location)
  {
    $location->delete();
    return back()->with('success', 'Location deleted successfully.');
  }
}

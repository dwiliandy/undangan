<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class WeddingEventController extends Controller
{
  public function edit(Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    // Ensure the relationship is loaded or return null if not exists
    $weddingEvent = $event->weddingEvent;

    return view('user.events.wedding_details', compact('event', 'weddingEvent'));
  }

  public function update(Request $request, Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    $request->validate([
      'groom_name' => 'required|string|max:255',
      'bride_name' => 'required|string|max:255',
      'groom_parent' => 'nullable|string|max:255',
      'bride_parent' => 'nullable|string|max:255',
    ]);

    $event->weddingEvent()->updateOrCreate(
      ['event_id' => $event->id],
      [
        'groom_name' => $request->groom_name,
        'bride_name' => $request->bride_name,
        'groom_parent' => $request->groom_parent,
        'bride_parent' => $request->bride_parent,
      ]
    );

    return redirect()->route('user.events.wedding-details.edit', $event->id)
      ->with('success', 'Wedding details updated successfully!');
  }
}

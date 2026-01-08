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
      'groom_photo' => 'nullable|image|max:2048',
      'bride_photo' => 'nullable|image|max:2048',
    ]);

    $data = [
      'groom_name' => $request->groom_name,
      'bride_name' => $request->bride_name,
      'groom_parent' => $request->groom_parent,
      'bride_parent' => $request->bride_parent,
    ];

    if ($request->hasFile('groom_photo')) {
      $data['groom_photo'] = $request->file('groom_photo')->store('weddings', 'public');
    }

    if ($request->hasFile('bride_photo')) {
      $data['bride_photo'] = $request->file('bride_photo')->store('weddings', 'public');
    }

    $event->weddingEvent()->updateOrCreate(
      ['event_id' => $event->id],
      $data
    );

    return back()->with('success', 'Wedding details updated successfully!');
  }
}

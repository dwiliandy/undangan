<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
  public function index(Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }
    $invitations = $event->invitations()->latest()->get();
    return view('user.invitations.index', compact('event', 'invitations'));
  }

  public function create(Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }
    return view('user.invitations.create', compact('event'));
  }

  public function store(Request $request, Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    $request->validate([
      'guest_name' => 'required|string|max:255',
      'guest_address' => 'nullable|string|max:255',
    ]);

    // Generate a unique slug for the invitation
    $slug = Str::slug($request->guest_name);
    // Ensure uniqueness within the event
    $count = 1;
    while ($event->invitations()->where('slug', $slug)->exists()) {
      $slug = Str::slug($request->guest_name) . '-' . $count;
      $count++;
    }

    $invitation = new Invitation();
    $invitation->event_id = $event->id;
    $invitation->guest_name = $request->guest_name;
    $invitation->guest_address = $request->guest_address;
    $invitation->slug = $slug;
    $invitation->save();

    return redirect()->route('user.events.invitations.index', $event->id)->with('success', 'Guest added successfully!');
  }

  public function edit(Event $event, Invitation $invitation)
  {
    if ($event->user_id !== auth()->id() || $invitation->event_id !== $event->id) {
      abort(403);
    }
    return view('user.invitations.edit', compact('event', 'invitation'));
  }

  public function update(Request $request, Event $event, Invitation $invitation)
  {
    if ($event->user_id !== auth()->id() || $invitation->event_id !== $event->id) {
      abort(403);
    }

    $request->validate([
      'guest_name' => 'required|string|max:255',
      'guest_address' => 'nullable|string|max:255',
    ]);

    // If name changes, we might want to update slug, but usually better to keep slug stable or ask user.
    // For simplicity, let's update slug if name changes to keep it consistent, ensuring uniqueness.
    if ($invitation->guest_name !== $request->guest_name) {
      $slug = Str::slug($request->guest_name);
      $count = 1;
      while ($event->invitations()->where('slug', $slug)->where('id', '!=', $invitation->id)->exists()) {
        $slug = Str::slug($request->guest_name) . '-' . $count;
        $count++;
      }
      $invitation->slug = $slug;
    }

    $invitation->guest_name = $request->guest_name;
    $invitation->guest_address = $request->guest_address;
    $invitation->save();

    return redirect()->route('user.events.invitations.index', $event->id)->with('success', 'Guest updated successfully!');
  }

  public function destroy(Event $event, Invitation $invitation)
  {
    if ($event->user_id !== auth()->id() || $invitation->event_id !== $event->id) {
      abort(403);
    }
    $invitation->delete();
    return redirect()->route('user.events.invitations.index', $event->id)->with('success', 'Guest removed successfully!');
  }
}

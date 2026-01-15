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
      'phone_number' => 'nullable|string|max:20',
      'guest_address' => 'nullable|string|max:255',
    ]);

    // Generate a unique slug for the invitation: snakeCase(name) + random 5 chars
    // e.g. john_doe_x7z9q
    $baseSlug = Str::kebab($request->guest_name);
    $slug = $baseSlug . '-' . Str::lower(Str::random(5));

    // Ensure uniqueness within the event (just in case of collision)
    while ($event->invitations()->where('slug', $slug)->exists()) {
      $slug = $baseSlug . '_' . Str::lower(Str::random(5));
    }

    $invitation = new Invitation();
    $invitation->event_id = $event->id;
    $invitation->guest_name = $request->guest_name;
    $invitation->phone_number = $request->phone_number;
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
      'phone_number' => 'nullable|string|max:20',
      'guest_address' => 'nullable|string|max:255',
    ]);

    // If name changes, update slug (optional but good for consistency)
    if ($invitation->guest_name !== $request->guest_name) {
      $baseSlug = Str::snake($request->guest_name);
      $slug = $baseSlug . '_' . Str::lower(Str::random(5));

      while ($event->invitations()->where('slug', $slug)->where('id', '!=', $invitation->id)->exists()) {
        $slug = $baseSlug . '_' . Str::lower(Str::random(5));
      }
      $invitation->slug = $slug;
    }

    $invitation->guest_name = $request->guest_name;
    $invitation->phone_number = $request->phone_number;
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

  public function import(Request $request, Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    $request->validate([
      'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:2048',
    ]);

    try {
      \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\InvitationImport($event->id), $request->file('file'));
      return redirect()->back()->with('success', 'Guests imported successfully!');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['file' => 'Error importing file: ' . $e->getMessage()]);
    }
  }
}

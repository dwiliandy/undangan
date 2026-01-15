<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class BirthdayEventController extends Controller
{
  public function update(Request $request, Event $event)
  {
    if ($event->user_id !== auth()->id()) {
      abort(403);
    }

    $request->validate([
      'person_name' => 'required|string|max:255',
      'age' => 'nullable|integer|min:0',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = [
      'person_name' => $request->person_name,
      'age' => $request->age
    ];

    if ($request->hasFile('photo')) {
      $path = $request->file('photo')->store('public/uploads/birthday_photos');
      $data['photo'] = $path;
    }

    $event->birthdayEvent()->updateOrCreate(
      ['event_id' => $event->id],
      $data
    );

    return back()->with('success', 'Birthday details updated successfully!');
  }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventGalleryController extends Controller
{
  public function store(Request $request, Event $event)
  {
    $request->validate([
      'image' => 'required|image|max:2048', // Max 2MB
    ]);

    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('galleries', 'public');

      $event->eventGalleries()->create([
        'image_path' => $path,
        'caption' => $request->caption,
      ]);
    }

    return back()->with('success', 'Photo added successfully.');
  }

  public function destroy(Event $event, EventGallery $gallery)
  {
    // Delete file from storage
    if ($gallery->image_path) {
      Storage::disk('public')->delete($gallery->image_path);
    }

    $gallery->delete();
    return back()->with('success', 'Photo deleted successfully.');
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\EventTemplate;
use App\Services\GuestService;

class FrontendController extends Controller
{
  public function event($slug)
  {
    $event = Event::with('template', 'weddingEvent', 'eventJourneys', 'eventLocations', 'eventGalleries', 'eventBanks')->where('slug', $slug)->where('is_active', true)->firstOrFail();

    // Use the event's template view path, fallback to a default if missing logic
    $templateView = $event->template ? $event->template->view_path : 'frontend.templates.v1';

    $wishes = $event->wishes;

    return view($templateView, compact('event', 'wishes'));
  }

  public function invitation($eventSlug, $invitationSlug)
  {
    $event = Event::with('template', 'weddingEvent', 'eventJourneys', 'eventLocations', 'eventGalleries', 'eventBanks')->where('slug', $eventSlug)->where('is_active', true)->firstOrFail();
    $invitation = $event->invitations()->where('slug', $invitationSlug)->firstOrFail();

    // Mark as opened if not already
    if (!$invitation->is_opened) {
      $invitation->is_opened = true;
      $invitation->opened_at = now();
      $invitation->save();
    }

    $templateView = $event->template ? $event->template->view_path : 'frontend.templates.v1';

    $wishes = $event->wishes;

    return view($templateView, compact('event', 'invitation', 'wishes'));
  }

  public function preview($templateSlug)
  {
    $template = EventTemplate::where('slug', $templateSlug)->firstOrFail();

    // Mock Event
    $event = new Event();
    $event->title = "Romeo & Juliet";
    $event->event_date = now()->addMonth()->format('Y-m-d H:i:s');
    $event->slug = "preview-event";

    // Mock Wedding Details
    $event->weddingEvent = (object) [
      'groom_name' => 'Romeo Montague',
      'bride_name' => 'Juliet Capulet',
      'groom_parent' => 'Mr. & Mrs. Montague',
      'bride_parent' => 'Mr. & Mrs. Capulet',
      'groom_photo' => asset('image/couple/grooms.jpg'),
      'bride_photo' => asset('image/couple/brides.jpg'),
      'groom_instagram' => 'romeo_montague',
      'bride_instagram' => 'juliet_capulet',
    ];

    // Mock Locations
    $event->eventLocations = collect([
      (object) [
        'name' => 'St. Peter\'s Basilica',
        'address' => 'Vatican City',
        'location_type' => 'akad',
        'event_time' => '10:00:00',
        'google_maps_url' => 'https://maps.google.com'
      ],
      (object) [
        'name' => 'Grand Ballroom',
        'address' => 'Plaza Hotel, New York',
        'location_type' => 'resepsi',
        'event_time' => '19:00:00',
        'google_maps_url' => 'https://maps.google.com'
      ]
    ]);

    // Mock Love Story
    $event->eventJourneys = collect([
      (object) ['journey_date' => now()->subYears(5), 'title' => 'First Meeting', 'description' => 'We met at a coffee shop in downtown Verona.'],
      (object) ['journey_date' => now()->subYears(3), 'title' => 'First Date', 'description' => 'Our first official date was a walk in the park.'],
      (object) ['journey_date' => now()->subYear(), 'title' => 'She Said Yes', 'description' => 'Proposed under the stars exactly where we met.']
    ]);

    // Mock Gallery
    $event->eventGalleries = collect([
      (object) ['image_path' => asset('image/gallery/1.jpg'), 'caption' => 'Gallery 1'],
      (object) ['image_path' => asset('image/gallery/2.jpg'), 'caption' => 'Gallery 2'],
      (object) ['image_path' => asset('image/gallery/3.jpg'), 'caption' => 'Gallery 3'],
      (object) ['image_path' => asset('image/gallery/4.jpg'), 'caption' => 'Gallery 4'],
      (object) ['image_path' => asset('image/gallery/5.jpg'), 'caption' => 'Gallery 5']
    ]);

    // Mock Angpao/Gift
    $event->eventBanks = collect([
      (object) ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'Romeo Montague'],
      (object) ['bank_name' => 'Mandiri', 'account_number' => '0987654321', 'account_name' => 'Juliet Capulet']
    ]);

    // Mock Wishes
    $wishes = collect([
      (object) ['name' => 'Mercutio', 'message' => 'Happy wedding you two! Have a blast!', 'created_at' => now()->subDay()],
      (object) ['name' => 'Benvolio', 'message' => 'Wishing you a lifetime of happiness.', 'created_at' => now()->subHour()]
    ]);

    // Mock Invitation
    $invitation = new Invitation();
    $invitation->guest_name = "Mr. John Doe";
    $invitation->guest_address = "Verona, Italy";
    $invitation->slug = "preview-guest";

    return view($template->view_path, compact('event', 'invitation', 'wishes'));
  }

  public function rsvp(Request $request, $slug, $invitationSlug)
  {
    $request->validate([
      'status' => 'required|in:yes,no',
      'total_guest' => 'nullable|integer|min:1',
      'message' => 'nullable|string',
    ]);

    // We need to resolve the event and invitation first
    // Assuming EventService can help or we use models directly for passing to GuestService
    // Ideally we use services. We can reuse getEventBySlug from EventService but that eager loads a lot.
    // Let's keep it simple for now and just resolve what we need.

    $event = \App\Models\Event::where('slug', $slug)->firstOrFail();
    $invitation = $event->invitations()->where('slug', $invitationSlug)->firstOrFail();

    // Use GuestService (we need to inject it)
    // Since I can't easily change constructor in this Replace block without replacing whole file,
    // I will resolve it from container or property if I added it.
    // I'll add it to property and constructor first.

    $rsvp = app(GuestService::class)->submitRsvp($invitation, $request->all());

    if ($request->ajax()) {
      $wishArgs = [
        'name' => $invitation->guest_name,
        'created_at_human' => 'Just now',
        'message' => $request->message
      ];

      return response()->json([
        'success' => true,
        'message' => 'Thank you for your response!',
        'wish' => $request->message ? $wishArgs : null
      ]);
    }

    return back()->with('success', 'Thank you for your response!');
  }
}

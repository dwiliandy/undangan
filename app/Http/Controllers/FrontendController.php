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
      'groom_name' => 'Monkey D. Luffy',
      'bride_name' => 'Boa Hancock',
      'groom_parent' => 'Monkey D. Dragon',
      'bride_parent' => 'Unknown',
      'groom_photo' => asset('image/couple/grooms.jpg'),
      'bride_photo' => asset('image/couple/grooms.jpg'),
      'groom_instagram' => 'luffy_pirateking',
      'bride_instagram' => 'hancock_empress',
    ];

    // Mock Locations
    $event->eventLocations = collect([
      (object) [
        'name' => 'Thousand Sunny Deck',
        'address' => 'New World Sea',
        'location_type' => 'ceremony',
        'event_time' => '10:00:00',
        'google_maps_url' => 'https://maps.google.com'
      ],
      (object) [
        'name' => 'Amazon Lily Palace',
        'address' => 'Calm Belt',
        'location_type' => 'reception',
        'event_time' => '19:00:00',
        'google_maps_url' => 'https://maps.google.com'
      ]
    ]);

    // Mock Love Story
    $event->eventJourneys = collect([
      (object) ['journey_date' => now()->subYears(2), 'title' => 'First Meeting', 'description' => 'Luffy fell from the sky into her bathhouse.'],
      (object) ['journey_date' => now()->subYears(1), 'title' => 'Marineford', 'description' => 'She gave him the key to his brother\'s cuffs.'],
      (object) ['journey_date' => now()->subYear(), 'title' => 'Proposal', 'description' => 'She practiced cooking meat for him every day.']
    ]);

    // Mock Gallery
    $event->eventGalleries = collect([
      (object) ['image_path' => 'https://static.wikia.nocookie.net/onepiece/images/a/a6/Thousand_Sunny_Infobox.png', 'caption' => 'Our Ship'],
      (object) ['image_path' => 'https://static.wikia.nocookie.net/onepiece/images/6/6f/Going_Merry_Infobox.png', 'caption' => 'Merry Go'],
      (object) ['image_path' => 'https://static.wikia.nocookie.net/onepiece/images/e/e6/Amazon_Lily_Infobox.png', 'caption' => 'Home'],
      (object) ['image_path' => 'https://static.wikia.nocookie.net/onepiece/images/6/6d/Whole_Cake_Chateau_Infobox.png', 'caption' => 'Cake?'],
      (object) ['image_path' => 'https://static.wikia.nocookie.net/onepiece/images/5/52/Baratie_Infobox.png', 'caption' => 'Food!']
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

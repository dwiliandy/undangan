<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\EventTemplate;

class FrontendController extends Controller
{
  public function event($slug)
  {
    $event = Event::where('slug', $slug)->where('is_active', true)->firstOrFail();

    // Load the template view based on event_template_id
    // For now, we assume a default template or map IDs to views.
    // Let's assume template ID 1 is 'modern'.
    $templateView = 'frontend.templates.modern';

    // If template management is dynamic, we'd look up the template.
    // For MVP, if template_id logic isn't fully built, default to one.

    return view($templateView, compact('event'));
  }

  public function invitation($eventSlug, $invitationSlug)
  {
    $event = Event::where('slug', $eventSlug)->where('is_active', true)->firstOrFail();

    $invitation = $event->invitations()->where('slug', $invitationSlug)->firstOrFail();

    // Mark as opened if not already
    if (!$invitation->is_opened) {
      $invitation->is_opened = true;
      $invitation->opened_at = now();
      $invitation->save();
    }

    $templateView = 'frontend.templates.modern';

    return view($templateView, compact('event', 'invitation'));
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
    $event->wedding = (object) [
      'groom_name' => 'Romeo Montague',
      'bride_name' => 'Juliet Capulet',
      'groom_parent' => 'Mr. & Mrs. Montague',
      'bride_parent' => 'Mr. & Mrs. Capulet',
    ];

    // Mock Locations
    $event->locations = collect([
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
    $event->love_stories = collect([
      (object) ['year' => '2018', 'title' => 'First Meeting', 'story' => 'We met at a coffee shop in downtown Verona.'],
      (object) ['year' => '2020', 'title' => 'First Date', 'story' => 'Our first official date was a walk in the park.'],
      (object) ['year' => '2023', 'title' => 'She Said Yes', 'story' => 'Proposed under the stars exactly where we met.']
    ]);

    // Mock Gallery
    $event->gallery = collect([
      (object) ['photo_url' => 'https://images.unsplash.com/photo-1511285560982-1351cdeb9821?auto=format&fit=crop&w=800&q=80'],
      (object) ['photo_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80'],
      (object) ['photo_url' => 'https://images.unsplash.com/photo-1519225421980-715cb0202128?auto=format&fit=crop&w=800&q=80'],
      (object) ['photo_url' => 'https://images.unsplash.com/photo-1520854221250-85d30a23c8a5?auto=format&fit=crop&w=800&q=80']
    ]);

    // Mock Angpao/Gift
    $event->angpaos = collect([
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
}

<?php

namespace App\Services;

use App\Repositories\Interfaces\RsvpRepositoryInterface;
use App\Repositories\Interfaces\WishRepositoryInterface;
use App\Models\Invitation;
use App\Models\Event;

class GuestService
{
  protected $rsvpRepository;
  protected $wishRepository;

  public function __construct(
    RsvpRepositoryInterface $rsvpRepository,
    WishRepositoryInterface $wishRepository
  ) {
    $this->rsvpRepository = $rsvpRepository;
    $this->wishRepository = $wishRepository;
  }

  public function submitRsvp(Invitation $invitation, array $data)
  {
    // Update or Create RSVP
    $rsvp = $this->rsvpRepository->updateOrCreate(
      ['invitation_id' => $invitation->id],
      [
        'status' => $data['status'],
        'total_guest' => $data['total_guest'] ?? 1,
        'responded_at' => now(),
      ]
    );

    // If message is present, create a Wish
    if (!empty($data['message'])) {
      $this->wishRepository->create([
        'event_id' => $invitation->event_id,
        'invitation_id' => $invitation->id,
        'name' => $invitation->guest_name,
        'message' => $data['message'],
      ]);
    }

    return $rsvp;
  }
}

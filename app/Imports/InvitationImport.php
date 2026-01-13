<?php

namespace App\Imports;

use App\Models\Invitation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class InvitationImport implements ToCollection
{
  protected $eventId;

  public function __construct($eventId)
  {
    $this->eventId = $eventId;
  }

  public function collection(Collection $rows)
  {
    $count = 0;
    foreach ($rows as $row) {
      // Skip header if it looks like a header (optional, or use WithHeadingRow)
      // For simplicity, let's assume if 1st column is 'Name' or 'Nama', skip
      if (strtolower($row[0]) == 'name' || strtolower($row[0]) == 'nama') {
        continue;
      }

      $name = $row[0] ?? null;
      if (!$name) continue;

      $phone = $row[1] ?? null;
      $address = $row[2] ?? null;

      // Generate Slug
      $slug = Str::slug($name);
      $slugCount = 1;
      // Check for existing slugs in this event (inefficient for large imports but safe for now)
      while (Invitation::where('event_id', $this->eventId)->where('slug', $slug)->exists()) {
        $slug = Str::slug($name) . '-' . $slugCount;
        $slugCount++;
      }

      Invitation::create([
        'event_id' => $this->eventId,
        'guest_name' => $name,
        'phone_number' => $phone,
        'guest_address' => $address,
        'slug' => $slug,
      ]);
      $count++;
    }
  }
}

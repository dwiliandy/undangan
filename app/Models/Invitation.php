<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
  protected $fillable = [
    'event_id',
    'guest_name',
    'phone_number',
    'guest_address',
    'slug',
    'is_opened',
    'opened_at',
  ];

  public function rsvp()
  {
    return $this->hasOne(Rsvp::class);
  }

  public function wishes()
  {
    return $this->hasMany(Wish::class);
  }
}

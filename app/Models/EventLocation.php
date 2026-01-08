<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
  protected $fillable = [
    'event_id',
    'name',
    'address',
    'latitude',
    'longitude',
    'google_maps_url',
    'location_type',
    'event_time',
    'order',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}

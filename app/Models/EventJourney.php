<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventJourney extends Model
{
  protected $fillable = [
    'event_id',
    'title',
    'description',
    'journey_date',
    'order',
  ];

  protected $casts = [
    'journey_date' => 'date',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}

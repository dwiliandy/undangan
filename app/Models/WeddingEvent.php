<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingEvent extends Model
{
  protected $fillable = [
    'event_id',
    'groom_name',
    'bride_name',
    'groom_parent',
    'bride_parent',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}

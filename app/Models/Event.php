<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  /** @use HasFactory<\Database\Factories\EventFactory> */
  use HasFactory;
  public function invitations()
  {
    return $this->hasMany(Invitation::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function template()
  {
    return $this->belongsTo(EventTemplate::class, 'event_template_id');
  }

  public function weddingEvent()
  {
    return $this->hasOne(WeddingEvent::class);
  }
}

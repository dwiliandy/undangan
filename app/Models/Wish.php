<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
  protected $fillable = [
    'event_id',
    'invitation_id',
    'name',
    'message',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }

  public function invitation()
  {
    return $this->belongsTo(Invitation::class);
  }
}

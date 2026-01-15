<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdayEvent extends Model
{
  protected $fillable = [
    'event_id',
    'person_name',
    'age',
    'photo',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}

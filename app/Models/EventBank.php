<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBank extends Model
{
  use HasFactory;

  protected $fillable = [
    'event_id',
    'bank_name',
    'account_number',
    'account_name',
  ];

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}

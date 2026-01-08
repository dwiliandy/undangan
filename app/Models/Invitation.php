<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
  protected $fillable = [
    'event_id',
    'guest_name',
    'guest_address',
    'slug',
    'is_opened',
    'opened_at',
  ];
}

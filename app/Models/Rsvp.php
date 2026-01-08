<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
  protected $fillable = [
    'invitation_id',
    'status',
    'total_guest',
    'responded_at',
  ];

  public function invitation()
  {
    return $this->belongsTo(Invitation::class);
  }
}

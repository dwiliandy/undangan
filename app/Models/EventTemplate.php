<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTemplate extends Model
{
  protected $fillable = [
    'name',
    'slug',
    'category',
    'thumbnail',
    'preview_image',
    'view_path',
    'is_active',
    'description',
  ];
}

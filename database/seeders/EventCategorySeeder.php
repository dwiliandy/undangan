<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EventTemplate;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
  public function run()
  {
    // 1. Update existing templates to 'wedding'
    EventTemplate::where('category', 'wedding')->update(['category' => 'wedding']); // Redundant but safe
    // Or if default is 'wedding' from migration, they are already 'wedding'.
    // Just in case migration default didn't apply retrospectively or whatever (it does for new columns mostly)

    // 2. Insert Birthday Templates if not exist
    $birthdays = [
      ['name' => 'Birthday Fun V1', 'slug' => 'birthday-v1', 'view_path' => 'frontend.templates.birthday.v1'],
      ['name' => 'Birthday Fun V2', 'slug' => 'birthday-v2', 'view_path' => 'frontend.templates.birthday.v2'],
      ['name' => 'Birthday Fun V3', 'slug' => 'birthday-v3', 'view_path' => 'frontend.templates.birthday.v3'],
      ['name' => 'Birthday Fun V4', 'slug' => 'birthday-v4', 'view_path' => 'frontend.templates.birthday.v4'],
      ['name' => 'Birthday Fun V5', 'slug' => 'birthday-v5', 'view_path' => 'frontend.templates.birthday.v5'],
      ['name' => 'Birthday Fun V6 (Superhero)', 'slug' => 'birthday-v6', 'view_path' => 'frontend.templates.birthday.v6'],
    ];

    foreach ($birthdays as $b) {
      EventTemplate::updateOrCreate(
        ['slug' => $b['slug']],
        [
          'name' => $b['name'],
          'view_path' => $b['view_path'],
          'category' => 'birthday',
          'is_active' => true,
          'thumbnail' => null, // User can update later
          'preview_image' => null
        ]
      );
    }
  }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventTemplate;

class TemplateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $templates = [
      [
        'name' => 'Modern Minimalist',
        'slug' => 'modern-minimalist',
        'view_path' => 'frontend.templates.v1',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Minimalist',
        'description' => 'Clean, white and black aesthetic with large typography.',
        'is_active' => true,
      ],
      [
        'name' => 'Pastel Floral',
        'slug' => 'pastel-floral',
        'view_path' => 'frontend.templates.v2',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Floral',
        'description' => 'Soft pinks and purples with floating floral elements.',
        'is_active' => true,
      ],
      [
        'name' => 'Luxury Dark',
        'slug' => 'luxury-dark',
        'view_path' => 'frontend.templates.v3',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Luxury',
        'description' => 'Exclusive dark theme with gold gradients and ornaments.',
        'is_active' => true,
      ],
    ];

    foreach ($templates as $template) {
      EventTemplate::updateOrCreate(['slug' => $template['slug']], $template);
    }
  }
}

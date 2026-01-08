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
        'description' => 'Clean, white and black aesthetic with large typography. Perfect for elegant and simple weddings.',
        'is_active' => true,
      ],
      [
        'name' => 'Pastel Floral',
        'slug' => 'pastel-floral',
        'view_path' => 'frontend.templates.v2',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Floral',
        'description' => 'Soft pinks and purples with floating floral elements. Romantic and dreamy vibe.',
        'is_active' => true,
      ],
      [
        'name' => 'Luxury Dark',
        'slug' => 'luxury-dark',
        'view_path' => 'frontend.templates.v3',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Luxury',
        'description' => 'Exclusive dark theme with gold gradients and ornaments. Gives a premium and formal feel.',
        'is_active' => true,
      ],
      [
        'name' => 'Retro Gamer',
        'slug' => 'retro-gamer',
        'view_path' => 'frontend.templates.v4',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Gamer',
        'description' => '8-bit pixel art style inspired by classic games. Fun, unique, and nostalgic.',
        'is_active' => true,
      ],
      [
        'name' => 'Cinema Streaming',
        'slug' => 'cinema-streaming',
        'view_path' => 'frontend.templates.v5',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Netflix',
        'description' => 'Inspired by popular streaming platforms. Modern, dark, and content-focused.',
        'is_active' => true,
      ],
      [
        'name' => 'Passport Travel',
        'slug' => 'passport-travel',
        'view_path' => 'frontend.templates.v6',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Passport',
        'description' => 'Designed like a passport and boarding pass. Ideal for destination weddings or travel lovers.',
        'is_active' => true,
      ],
      [
        'name' => 'Music Player',
        'slug' => 'music-player',
        'view_path' => 'frontend.templates.v7',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Spotify',
        'description' => 'Mimics a music streaming app interface. Cool, gradient-heavy, and interactive.',
        'is_active' => true,
      ],
      [
        'name' => 'Natural Earth',
        'slug' => 'natural-earth',
        'view_path' => 'frontend.templates.v8',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Nature',
        'description' => 'Earthy tones with sage green and leaf animations. Warm, organic, and peaceful.',
        'is_active' => true,
      ],
      [
        'name' => 'Match Day Sport',
        'slug' => 'match-day',
        'view_path' => 'frontend.templates.v9',
        'thumbnail' => 'https://via.placeholder.com/300x200?text=Sport',
        'description' => 'High-energy sports broadcast theme. Bold fonts, scoreboards, and competitive vibes.',
        'is_active' => true,
      ],
    ];

    foreach ($templates as $template) {
      EventTemplate::updateOrCreate(['slug' => $template['slug']], $template);
    }
  }
}

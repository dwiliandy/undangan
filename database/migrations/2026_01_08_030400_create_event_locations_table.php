<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('event_locations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
      $table->string('name');
      $table->text('address');
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
      $table->string('google_maps_url')->nullable();
      $table->enum('location_type', ['akad', 'resepsi', 'party', 'online']);
      $table->time('event_time');
      $table->integer('order')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('event_locations');
  }
};

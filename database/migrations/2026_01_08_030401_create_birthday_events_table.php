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
    Schema::create('birthday_events', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->unique()->constrained('events')->onDelete('cascade');
      $table->string('person_name');
      $table->integer('age')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('birthday_events');
  }
};

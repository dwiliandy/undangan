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
    Schema::create('invitations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
      $table->string('guest_name');
      $table->string('guest_address')->nullable();
      $table->string('slug');
      $table->boolean('is_opened')->default(false);
      $table->timestamp('opened_at')->nullable();
      $table->timestamps();

      $table->unique(['event_id', 'slug']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('invitations');
  }
};

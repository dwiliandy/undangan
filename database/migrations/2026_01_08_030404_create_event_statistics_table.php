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
    Schema::create('event_statistics', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->unique()->constrained('events')->onDelete('cascade');
      $table->integer('total_invitations')->default(0);
      $table->integer('total_opened')->default(0);
      $table->integer('total_rsvp_yes')->default(0);
      $table->integer('total_rsvp_no')->default(0);
      $table->integer('total_angpao')->default(0);
      $table->decimal('total_angpao_amount', 14, 2)->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('event_statistics');
  }
};

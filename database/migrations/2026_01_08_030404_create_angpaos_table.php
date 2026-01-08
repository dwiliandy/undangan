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
    Schema::create('angpaos', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
      $table->foreignId('invitation_id')->nullable()->constrained('invitations')->onDelete('set null');
      $table->string('sender_name');
      $table->decimal('amount', 12, 2);
      $table->string('payment_method');
      $table->enum('status', ['pending', 'success']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('angpaos');
  }
};

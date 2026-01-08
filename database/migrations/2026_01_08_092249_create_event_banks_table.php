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
    Schema::create('event_banks', function (Blueprint $table) {
      $table->id();
      $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
      $table->string('bank_name');
      $table->string('account_number');
      $table->string('account_name');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('event_banks');
  }
};

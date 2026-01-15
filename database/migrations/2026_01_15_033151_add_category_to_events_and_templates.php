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
    Schema::table('events', function (Blueprint $table) {
      $table->enum('category', ['wedding', 'birthday'])->default('wedding')->after('slug');
    });

    Schema::table('event_templates', function (Blueprint $table) {
      $table->enum('category', ['wedding', 'birthday'])->default('wedding')->after('slug');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('events_and_templates', function (Blueprint $table) {
      //
    });
  }
};

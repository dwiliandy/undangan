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
    Schema::table('event_templates', function (Blueprint $table) {
      $table->string('view_path')->after('name');
      $table->string('thumbnail')->nullable()->after('view_path');
      $table->string('preview_image')->nullable()->after('thumbnail');
      $table->text('description')->nullable()->after('preview_image');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('event_templates', function (Blueprint $table) {
      //
    });
  }
};

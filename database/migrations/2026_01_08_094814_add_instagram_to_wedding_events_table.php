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
    Schema::table('wedding_events', function (Blueprint $table) {
      $table->string('groom_instagram')->nullable()->after('groom_photo');
      $table->string('bride_instagram')->nullable()->after('bride_photo');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('wedding_events', function (Blueprint $table) {
      $table->dropColumn(['groom_instagram', 'bride_instagram']);
    });
  }
};

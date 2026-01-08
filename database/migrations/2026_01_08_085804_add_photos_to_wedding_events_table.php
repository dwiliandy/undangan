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
      $table->string('groom_photo')->nullable()->after('groom_parent');
      $table->string('bride_photo')->nullable()->after('bride_parent');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('wedding_events', function (Blueprint $table) {
      $table->dropColumn(['groom_photo', 'bride_photo']);
    });
  }
};

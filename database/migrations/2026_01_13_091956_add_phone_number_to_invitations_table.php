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
    Schema::table('invitations', function (Blueprint $table) {
      $table->string('phone_number')->nullable()->after('guest_name'); // Assuming 'type' exists, or just after id/event_id
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('invitations', function (Blueprint $table) {
      $table->dropColumn('phone_number');
    });
  }
};

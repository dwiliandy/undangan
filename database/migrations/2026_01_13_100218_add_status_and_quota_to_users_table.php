<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('status', ['pending', 'active', 'rejected'])->default('pending')->after('role');
      $table->integer('event_quota')->default(0)->after('status');
    });

    // Set existing users to active and give them quota
    DB::table('users')->update(['status' => 'active', 'event_quota' => 10]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['status', 'event_quota']);
    });
  }
};

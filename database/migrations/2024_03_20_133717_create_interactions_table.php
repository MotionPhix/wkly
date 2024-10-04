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
    Schema::create('interactions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('contact_id');
      $table->text('description');
      $table->string('interaction_type'); // e.g., 'meeting', 'phone call'
      $table->date('event_date');
      $table->string('location');
      $table->timestamps();

      // Define foreign keys
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('interactions');
  }
};

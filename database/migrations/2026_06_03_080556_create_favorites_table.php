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
       Schema::create('favorites', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('user_id');
    $table->string('imdb_id');

    $table->string('title');
    $table->string('year')->nullable();
    $table->string('poster')->nullable();
    $table->string('type')->nullable();

    $table->timestamps();

    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
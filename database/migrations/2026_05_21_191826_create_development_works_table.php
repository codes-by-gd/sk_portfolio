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
        Schema::create('development_works', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_gu');
            $table->string('title_hi');
            $table->text('description_en');
            $table->text('description_gu');
            $table->text('description_hi');
            $table->string('location');
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('development_works');
    }
};

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
        // 1. Add complaint_number to complaints table
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('complaint_number')->nullable()->unique()->after('id');
        });

        // 2. Create complaint_logs table
        Schema::create('complaint_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id');
            $table->string('status');
            $table->text('message');
            $table->timestamps();

            $table->foreign('complaint_id')
                ->references('id')
                ->on('complaints')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_logs');

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('complaint_number');
        });
    }
};

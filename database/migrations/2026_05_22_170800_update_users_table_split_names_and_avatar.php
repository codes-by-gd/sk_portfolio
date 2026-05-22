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
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('avatar_path')->nullable()->after('password');
        });

        // Split existing 'name' into 'first_name' and 'last_name'
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $parts = explode(' ', $user->name, 2);
            $firstName = $parts[0] ?? '';
            $lastName = $parts[1] ?? '';
            
            DB::table('users')->where('id', $user->id)->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        // Recombine
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $name = trim($user->first_name . ' ' . $user->last_name);
            DB::table('users')->where('id', $user->id)->update([
                'name' => $name,
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->dropColumn(['first_name', 'last_name', 'avatar_path']);
        });
    }
};

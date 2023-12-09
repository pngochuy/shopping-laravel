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
        Schema::table('country', function (Blueprint $table) {
            // add columns
            $table->string("country")->after("id");
        });

        DB::table('country')->insert(['country' => 'Lodon']);
        DB::table('country')->insert(['country' => 'India']);
        DB::table('country')->insert(['country' => 'USA']);
        DB::table('country')->insert(['country' => 'Canada']);
        DB::table('country')->insert(['country' => 'Thailand']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('country', function (Blueprint $table) {
            //
        });
    }
};

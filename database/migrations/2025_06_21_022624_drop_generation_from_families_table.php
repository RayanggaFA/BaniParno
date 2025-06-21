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
        // Cek apakah kolom generation ada di tabel families
        if (Schema::hasColumn('families', 'generation')) {
            Schema::table('families', function (Blueprint $table) {
                $table->dropColumn('generation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->integer('generation')->nullable();
        });
    }
};
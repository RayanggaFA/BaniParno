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
        // Cek apakah kolom generation sudah ada
        if (Schema::hasColumn('families', 'generation')) {
            // Jika ada, update semua record yang generation-nya NULL menjadi 1
            DB::table('families')->whereNull('generation')->update(['generation' => 1]);
            
            // Ubah kolom generation agar punya default value
            Schema::table('families', function (Blueprint $table) {
                $table->integer('generation')->default(1)->change();
            });
        } else {
            // Jika belum ada, tambahkan kolom generation dengan default 1
            Schema::table('families', function (Blueprint $table) {
                $table->integer('generation')->default(1)->after('branch');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak melakukan apa-apa karena kita tidak ingin hapus kolom generation
    }
};
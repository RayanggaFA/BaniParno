<?php
// database/migrations/2024_01_01_000001_create_families_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('branch'); // Cabang keluarga (Parno 1, Parno 2, dll)
            $table->integer('generation');
            $table->text('description')->nullable();
            $table->string('color')->default('#3B82F6'); // Warna untuk identitas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('families');
    }
};


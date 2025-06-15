<?php
// database/migrations/2024_01_01_000004_create_member_histories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('field_changed'); // Field yang berubah
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('changed_by'); // User yang mengubah
            $table->text('reason')->nullable(); // Alasan perubahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_histories');
    }
};
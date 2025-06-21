<?php
// database/migrations/2024_01_01_000002_create_members_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('job');
            $table->text('address_ktp'); 
            $table->string('domicile_city');
            $table->string('domicile_province');
            $table->text('current_address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('members')->onDelete('set null'); // Untuk family tree
            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['active', 'inactive', 'deceased'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};




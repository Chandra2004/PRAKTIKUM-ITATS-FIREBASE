<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_07_04_034707_CreateUsersTable
{
    public function up()
    {
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->string('profile_picture')->nullable();
            $table->string('full_name');
            $table->string('phone')->nullable();
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('semester');
            $table->string('password');
            
            
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('email')->unique();
            $table->string('npm_nip')->unique();
            $table->string('posisi');
            $table->string('initials');
            
            
            $table->string('role_uid');
            $table->string('id_card');

            $table->foreign('role_uid')->references('uid')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', [1, 0]);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

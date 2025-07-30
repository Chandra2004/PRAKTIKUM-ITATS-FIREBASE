<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_07_04_034654_CreateRolesTable
{
    public function up()
    {
        Schema::create('roles', function ($table) {
            $table->id();
            $table->string('uid', 10)->unique();
            $table->string('role_name');
            $table->string('description_role')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_08_06_083852_CreateModulesTable
{
    public function up() {
        Schema::create('modules', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->string('course_uid_module');
            $table->string('title_module');
            $table->string('location_module');
            $table->string('date_module');
            $table->string('description_module');
            
            $table->timestamps();

            $table->foreign('course_uid_module')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
}

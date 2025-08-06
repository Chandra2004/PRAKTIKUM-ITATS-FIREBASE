<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_07_28_055718_CreateCoursesTable
{
    public function up()
    {
        Schema::create('courses', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->string('code_course');
            $table->string('title_course');
            $table->text('description_course');

            $table->string('uid_creator_course');
            $table->foreign('uid_creator_course')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}

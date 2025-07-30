<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_07_28_171454_CreateUserCourseTable
{
    public function up()
    {
        Schema::create('user_course', function ($table) {
            $table->id();
            $table->string('uid')->unique();
            
            $table->string('user_uid')->unique();
            $table->string('course_uid')->unique();

            $table->foreign('user_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_uid')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_course');
    }
}

<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_08_05_142023_CreateSessionsTable
{
    public function up()
    {
        Schema::create('sessions', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->string('course_uid_session');
            $table->string('title_session');
            $table->string('kuota_session');
            $table->string('time_start_session');
            $table->string('time_end_session');
            $table->dateTime('deadline_session');

            $table->timestamps();
            
            $table->foreign('course_uid_session')->references('uid')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}

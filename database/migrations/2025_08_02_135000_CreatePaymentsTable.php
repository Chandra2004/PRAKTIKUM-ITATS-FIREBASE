<?php

namespace Database\Migrations;

use ITATS\PraktikumTeknikSipil\App\Schema;

class Migration_2025_08_02_135000_CreatePaymentsTable
{
    public function up()
    {
        Schema::create('payments', function ($table) {
            $table->id();
            $table->string('uid')->unique();

            $table->string('number_receipt');
            $table->string('uid_user_receipt');
            $table->string('payment_purpose_receipt');
            $table->string('amount_receipt');
            
            $table->foreign('uid_user_receipt')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

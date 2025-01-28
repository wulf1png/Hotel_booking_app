<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestEmailToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Добавляем поле для email
            $table->string('guest_email')->nullable(); // Если email не обязателен, можно использовать nullable()
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Удаляем поле guest_email, если миграция откатится
            $table->dropColumn('guest_email');
        });
    }
}

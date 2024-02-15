<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatetimeColumnToString extends Migration
{
    public function up()
    {
        Schema::table('editais', function (Blueprint $table) {
            $table->string('numero_edital')->change();
        });
    }

    public function down()
    {
        Schema::table('editais', function (Blueprint $table) {
            $table->dateTime('numero_edital')->change();
        });
    }
}
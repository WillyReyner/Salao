<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscolaResponsaveisTable extends Migration
{
    public function up()
    {
        Schema::create('escola_responsaveis', function (Blueprint $table) {
            $table->foreignId('escola_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escola_responsaveis');
    }
}

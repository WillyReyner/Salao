<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edital_tipo_arquivo', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->foreignId('edital_id')->constrained('editais');
            $table->foreignId('tipo_arquivo_id')->constrained('tipo_arquivos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edital_tipo_arquivo');
    }
};
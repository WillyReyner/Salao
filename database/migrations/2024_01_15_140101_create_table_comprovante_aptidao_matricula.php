<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('comprovante_aptidao_matricula', function (Blueprint $table) {
            $table->id();
            $table->string('caminho')->nullable();
            $table->string('situacao')->nullable();
            $table->string('status')->nullable();
            $table->string('nome_arquivo')->nullable();
            $table->text('link')->nullable();
        
            // Certifique-se de que os tipos de coluna correspondem
            $table->unsignedBigInteger('tipo_arquivo_id')->nullable();
            $table->foreign('tipo_arquivo_id')->references('id')->on('tipo_arquivos')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('inscricao_id')->nullable();
            $table->foreign('inscricao_id')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('comprovante_aptidao_matricula');
    }
};

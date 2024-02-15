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
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo')->nullable();
            $table->string('cpf')->nullable();
            $table->string('email')->nullable();
            $table->string('email_confirmation')->nullable();
            $table->string('rede')->nullable();
            $table->string('raca')->nullable();
            $table->string('outro_raca')->nullable();
            $table->string('genero')->nullable();
            $table->string('outro_genero')->nullable();
            $table->string('telefone')->nullable();
            $table->string('telefone_alternativo')->nullable();
            $table->string('cep')->nullable();
            $table->string('municipio')->nullable();
            $table->string('estado')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('escolaridade')->nullable();
            $table->string('origem_escolar')->nullable();
            $table->string('programa_social')->nullable();
            $table->string('nis_pis')->nullable();
            $table->string('outro_programa_social')->nullable();
            $table->string('deficiencia')->nullable();
            $table->string('outra_deficiencia')->nullable();
            $table->string('como_conheceu')->nullable();
            $table->string('outro_como_conheceu')->nullable();
            $table->string('situacao')->nullable();
            $table->string('lgpd')->nullable();
            $table->string('documento')->nullable();
            $table->string('tipo_documento')->nullable();
            
            $table->foreignId('turma_id')->nullable()->constrained('turmas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('habilitacao_id')->nullable()->constrained('habilitacao')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};

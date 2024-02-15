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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('situacao')->nullable();
            $table->string('turno')->nullable();
            $table->string('modalidade')->nullable();
            $table->string('faixa_etaria')->nullable();
            $table->string('vagas')->nullable();
            $table->string('dias_semana')->nullable();
            $table->datetime('data_inicio')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_termino')->nullable();

            $table->string('habilitacao')->nullable();

            $table->string('teste_aptidao')->nullable();

            $table->string('teste_aptidao_local_online')->nullable();
            $table->string('teste_aptidao_local_presencial')->nullable();
            $table->string('teste_aptidao_exigidos')->nullable();
            $table->datetime('teste_aptidao_data_online')->nullable();
            
            
            $table->datetime('teste_aptidao_data_presencial')->nullable();
            $table->time('teste_aptidao_hora_presencial')->nullable();
            $table->string('teste_aptidao_sala_presencial')->nullable();

            $table->string('teste_aptidao_idade')->nullable();
            $table->string('teste_aptidao_idade_minima')->nullable();
            
            $table->foreignId('edital_id')->constrained('editais')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('teste_aptidao_escola_presencial')->constrained('escolas')->onDelete('cascade')->onUpdate('cascade')->nullable();
            
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
        Schema::dropIfExists('turmas');
    }
};

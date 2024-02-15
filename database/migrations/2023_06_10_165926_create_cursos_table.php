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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('id_curso_siga')->nullable();
            $table->string('escola_curso_siga')->nullable();
            $table->string('situacao')->nullable();
	        $table->string('destaque')->nullable();
	        $table->string('link_video_apresentacao')->nullable();
	        $table->string('horas_curso')->nullable();
	        $table->string('nivel')->nullable();
	        $table->string('faixa_etaria')->nullable();
	        $table->string('area')->nullable();
	        $table->string('subarea')->nullable();
	        $table->string('texto_site')->nullable();
			$table->string('des_texto_site')->nullable();
	        $table->string('disciplina')->nullable();
	        $table->boolean('des_disciplina')->nullable();
	        $table->string('conteudo_programatico')->nullable();
	        $table->boolean('des_conteudo')->nullable();
	        $table->string('area_atuacao')->nullable();
	        $table->boolean('des_area_atuacao')->nullable();
	        $table->string('imagem')->nullable();

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
        Schema::dropIfExists('cursos');
    }
};

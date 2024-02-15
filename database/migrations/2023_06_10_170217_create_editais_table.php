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
        Schema::create('editais', function (Blueprint $table) {
            $table->id();
			$table->string('nome')->nullable();
            $table->string('numero_edital')->nullable();
			$table->string('area')->nullable();
            $table->string('situacao')->nullable();
            $table->string('documentos_matricula')->nullable();
            $table->string('documentos_inscricao')->nullable();
            $table->string('agendar_publicacao')->nullable();
            $table->string('udepi')->nullable();
            $table->string('contagem_editais')->nullable();
            $table->string('dt_publicacao')->nullable();
            $table->string('dt_fim_edital')->nullable();
            $table->string('dt_inicio_inscricao')->nullable();
            $table->string('dt_fim_inscricao')->nullable();
            
            $table->foreignId('escola_id')->constrained('escolas')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('municipio_id')->constrained('municipios')->onDelete('cascade')->onUpdate('cascade')->nullable();
            
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
        Schema::dropIfExists('editais');
    }
};

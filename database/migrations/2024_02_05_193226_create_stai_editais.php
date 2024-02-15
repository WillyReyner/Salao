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
        Schema::create('stai_editais', function (Blueprint $table) {
            $table->id();
			$table->string('nome');
			$table->string('tipo');
			$table->date('data_publicacao');
			$table->date('data_fim_edital');
			$table->date('dt_inicio_inscricao');
			$table->date('dt_fim_inscricao');
			$table->string('situacao');

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
        Schema::dropIfExists('stai_editais');
    }
};

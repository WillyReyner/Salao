<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('comprovantematriculas', function (Blueprint $table) {
			$table->id();
			$table->string('caminho')->nullable();
			$table->string('situacao')->nullable();
			$table->string('status')->nullable();
			$table->string('nome_arquivo')->nullable();
			$table->string('tipo')->nullable();

			// Certifique-se de que os tipos de coluna correspondem
			$table->unsignedBigInteger('tipo_arquivo_id')->nullable();
			$table->foreign('tipo_arquivo_id')->references('id')->on('tipo_arquivos')->onDelete('cascade')->onUpdate('cascade');

			$table->unsignedBigInteger('inscricao_id')->nullable();
			$table->foreign('inscricao_id')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('comprovantematriculas');
	}
};


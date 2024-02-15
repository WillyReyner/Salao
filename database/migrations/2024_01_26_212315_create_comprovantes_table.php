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
        
        Schema::create('comprovantes', function (Blueprint $table) {
            $table->id();
            $table->string('caminho')->nullable();
            $table->string('situacao')->nullable();
            $table->string('tipo_arquivo_id')->nullable();
            $table->string('status')->nullable();
            
            $table->foreignId('inscricao_id')->nullable()->constrained('inscricoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprovantes');
    }
};

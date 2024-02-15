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
        Schema::create('escolas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('situacao')->nullable();
            $table->string('rede')->nullable();
            $table->string('ficha')->nullable();
            $table->string('endereco_completo')->nullable();
            $table->string('contato')->nullable();
            $table->string('user_id')->nullable();

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
        Schema::dropIfExists('escolas');
    }
};

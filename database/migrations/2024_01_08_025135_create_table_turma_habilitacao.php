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
        Schema::create('turma_habilitacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->nullable()->constrained('turmas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('habilitacao_id')->nullable()->constrained('habilitacao')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('table_turma_habilitacao');
    }
};

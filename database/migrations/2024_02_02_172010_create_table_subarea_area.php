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
		Schema::create('subarea_area', function (Blueprint $table) {
			$table->id();

			$table->foreignId('subarea_id')->constrained('subareas')->onDelete('cascade')->onUpdate('cascade');
			$table->foreignId('area_id')->constrained('areas')->onDelete('cascade')->onUpdate('cascade');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('subarea_area');
	}
};
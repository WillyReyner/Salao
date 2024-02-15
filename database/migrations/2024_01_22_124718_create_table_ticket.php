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
		Schema::create('tickets', function (Blueprint $table) {
			$table->id();
			$table->text('tickets')->nullable();
			$table->boolean('read')->default(false);

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
		Schema::dropIfExists('tickets');
	}
};

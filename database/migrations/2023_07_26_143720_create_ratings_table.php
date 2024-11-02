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
		Schema::create('ratings', function (Blueprint $table) {
			$table->id();
			$table->float('score');

			// morphs >> This method is intended to be used when defining the columns necessary for a polymorphic Eloquent relationship. Crea automaticamente dos campos relacionados un _id y un _type

			// Entidad a la que quiero calificar
			$table->morphs('rateable');
			// $table->unsignedBigInteger('rateable_id')
			// $table->string('rateable_type')

			// Entidad que realiza la calificacion
			$table->morphs('qualifier');
			// $table->unsignedBigInteger('qualifier_id')
			// $table->string('qualifier_type')

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('ratings');
	}
};

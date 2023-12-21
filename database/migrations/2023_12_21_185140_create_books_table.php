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
		Schema::create('books', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('publisher');
			$table->string('isbn');
			$table->string('category');
			$table->string('sub_category');
			$table->string('description');
			$table->integer('pages');
			$table->string('image');
			$table->foreignId('added_by')->constrained('users');
			$table->timestamps();
			//deleted_at
			$table->softDeletes();
		});
	}

	/**
		* Reverse the migrations.
		*/
	public function down(): void
	{
		Schema::dropIfExists('books');
	}
};

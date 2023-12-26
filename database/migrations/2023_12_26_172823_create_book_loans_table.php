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
		Schema::create('book_loans', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascase');
			$table->foreignId('book_id')->constrained()->onDelete('cascade');
			$table->date('loan_date');
			$table->date('due_dloan_dateate');
			$table->date('return_date');
			$table->string('extended');
			$table->date('extension_date');
			$table->integer('penalty_amount');
			$table->string('penalty_status');
			$table->string('status');
			$table->foreignId('added_by')->constrained('users');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
		* Reverse the migrations.
		*/
	public function down(): void
	{
		Schema::dropIfExists('book_loans');
	}
};

<?php

namespace App\Models;

use App\Events\BookLoanRequested;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
	use HasFactory;

	protected $fillable = [
		'book_id',
		'added_by',
		'loan_date',
		'due_date',
		'return_date',
		'extended',
		'extension_date',
		'penalty_amount',
		'penalty_status',
		'status',
	];


	protected $dispatchesEvents = [
		'created' => BookLoanRequested::class,
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function book(): BelongsTo
	{
		return $this->belongsTo(Book::class, 'book_id');
	}
}

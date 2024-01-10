<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'name',
		'publisher',
		'isbn',
		'category',
		'sub_category',
		'description',
		'pages',
		'image',
		'available'
	];



	function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	function loans(): HasMany
	{
		return $this->hasMany(BookLoan::class, 'book_id');
	}
}

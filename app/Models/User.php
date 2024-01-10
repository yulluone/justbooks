<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\UserRegistered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
		* The attributes that are mass assignable.
		*
		* @var array<int, string>
		*/
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	protected $dispatchesEvents = [
		'created' => UserRegistered::class,
	];

	/**
		* The attributes that should be hidden for serialization.
		*
		* @var array<int, string>
		*/
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
		* The attributes that should be cast.
		*
		* @var array<string, string>
		*/
	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
	];

	public function books(): HasMany
	{
		return $this->hasMany(Book::class, 'added_by');
	}

	public function book_loans(): HasMany
	{
		//do something to also link "book_id"
		return $this->hasMany(BookLoan::class);
	}
}

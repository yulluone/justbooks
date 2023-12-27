<?php

namespace App\Policies;

use App\Models\BookLoan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookLoanPolicy
{
	/**
		* Determine whether the user can view any models.
		*/
	public function viewAny(User $user): bool
	{
		//
	}

	/**
		* Determine whether the user can view the model.
		*/
	public function view(User $user, BookLoan $bookLoan): bool
	{
		//
	}

	/**
		* Determine whether the user can create book loans.
		*/
	public function store(User $user, Book $book): bool
	{
		return $book->availble;
	}

	/**
		* Determine whether the user can update the model.
		*/
	public function update(User $user, BookLoan $bookLoan): bool
	{
		//
	}

	/**
		* Determine whether the user can delete the model.
		*/
	public function delete(User $user, BookLoan $bookLoan): bool
	{
		//
	}

	/**
		* Determine whether the user can restore the model.
		*/
	public function restore(User $user, BookLoan $bookLoan): bool
	{
		//
	}

	/**
		* Determine whether the user can permanently delete the model.
		*/
	public function forceDelete(User $user, BookLoan $bookLoan): bool
	{
		//
	}
}

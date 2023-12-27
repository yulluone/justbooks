<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BookLoanController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index(): Response
	{
		return response('Book Loans');
	}

	/**
		* Show the form for creating a new resource.
		*/
	public function create()
	{
		//
	}

	/**
		* Store a newly created resource in storage.
		*/
	public function store(Request $request, Book $book): RedirectResponse
	{

		$borrowed_book = Book::find($request->input('book_id'));

		// $this->authorize('store', $book);

		$validated = $request->validate([
			'loan_date' => "required|date",
			'due_date' => "required|date",
		]);

		$bookLoan = $request->user()->book_loans()->create([
			'loan_date' => $validated['loan_date'],
			'due_date' => $validated['due_date'],
			'book_id' => $borrowed_book->id,
			'added_by' => $request->user()->id,
		]);

		// Associate this loan with the book
		$bookLoan->book()->associate($borrowed_book);
		$bookLoan->save();

		// Update book availabiliy
		$book->update(['availble' => 0]);

		return redirect(route('books.index'));

	}

	/**
		* Display the specified resource.
		*/
	public function show(BookLoan $bookLoan)
	{
		//
	}

	/**
		* Show the form for editing the specified resource.
		*/
	public function edit(BookLoan $bookLoan)
	{
		//
	}

	/**
		* Update the specified resource in storage.
		*/
	public function update(Request $request, BookLoan $bookLoan)
	{
		//
	}

	/**
		* Remove the specified resource from storage.
		*/
	public function destroy(BookLoan $bookLoan)
	{
		//
	}
}

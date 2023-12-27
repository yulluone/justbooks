<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BookLoanController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index()
	{
		$user = Auth::user();

		if ($user->isAdmin) {
			$loans = BookLoan::with([
				'book' => function ($query) {
					$query->select('id', 'name', 'image');
				}
			])->latest()->get();
		} else {
			$loans = BookLoan::where("user_id", $user->id)->with([
				'book' => function ($query) {
					$query->select('id', 'name', 'image');
				}
			])->latest()->get();
		}

		return Inertia::render('Loans/Index', [
			'loans' => $loans,
		]);
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
	public function store(Request $request): RedirectResponse
	{

		$book = Book::find($request->input('book_id'));

		// $this->authorize('store', $book);

		$validated = $request->validate([
			'loan_date' => "required|date",
			'due_date' => "required|date",
		]);

		$bookLoan = $request->user()->book_loans()->create([
			'loan_date' => $validated['loan_date'],
			'due_date' => $validated['due_date'],
			'book_id' => $book->id,
			'added_by' => $request->user()->id,
		]);

		// Associate this loan with the book
		$bookLoan->book()->associate($book);
		$bookLoan->save();

		// Update book availabiliy
		$book->update(['available' => false]);

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
	public function update(Request $request, $bookLoanId): Response
	{
		$validated = $request->validate([
			"id" => "required|integer",
			"due_date" => "required|date",
			"extended" => "required|boolean",
			"extension_date" => "required|date",
		]);
		$bookLoan = BookLoan::find($bookLoanId);
		// $bookLoan->update(['status' => "active"]);


		$updated = $bookLoan->update([
			'due_date' => $validated['due_date'],
			'extension' => $validated['extended'],
			'extension_date' => $validated['extension_date']
		]);

		return response($updated, 200);

	}

	/**
		* Remove the specified resource from storage.
		*/
	public function destroy(BookLoan $bookLoan)
	{
		//
	}

	/**
		* Approve Book Loan
		*/

	public function approve(Request $request): RedirectResponse
	{
		$book_loan = BookLoan::find($request->input('id'));
		// $user = $request->user(); 
		// $this->authorize('update', $user);

		$book_loan->update(['status' => 'active']);

		return redirect(route("loans.index"));
	}

	/**
		* Extend the due date of a book loan.
		*/
	public function extend(Request $request): RedirectResponse
	{
		$bookLoan = BookLoan::find($request->input('id'));

		$bookLoan->update([
			'due_date' => $request->input('due_date'),
			'extended' => 1,
			'extension_date' => $request->input('extension_date')
		]);

		return redirect(route("loans.index"));

	}

	public function receive(Request $request): RedirectResponse
	{
		$bookLoan = BookLoan::find($request->input('id'));

		$bookLoan->update([
			'return_date' => $request->input('due_date'),
			'status' => 'returned',
		]);

		$book = Book::find($request->input('book_id'));
		$book->update(['available' => true]);

		return redirect(route("loans.index"));

	}


}


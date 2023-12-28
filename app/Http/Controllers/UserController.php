<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index()
	{
		$user = Auth::user();
		$this->authorize("ViewAny", $user);

		$currentUserId = Auth::id();


		// Fetch users excluding the authenticated user
		$users = User::where('id', '!=', $currentUserId)->latest()->get();

		return Inertia::render('Users/Index', [
			'users' => $users,
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
		//

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
		//

	}

	public function updateIsAdmin(Request $request)
	{

		$this->authorize('updateIsAdmin', Auth::user());

		$user = User::find($request->input('user_id'));

		$user->isAdmin = $request->input('isAdmin');

		return $user;
		// $user->save();

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



}


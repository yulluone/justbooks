<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index(): Response
	{
		return Inertia::render('Books/Index', [
			//
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
		//validate data
		$validated = $request->validate([
			'name' => "required|string|max:200",
			'publisher' => "required|string|max:50",
			'isbn' => "required|string|max:50",
			'category' => "required|string|max:100",
			'sub_category' => "required|string|max:100",
			'description' => "required|string",
			'pages' => "required|integer|max:2147483648",
			'image' => "required|string|max:200"
		]);

		$request->user()->books()->create($validated);

		return redirect(route('books.index'));

	}

	/**
		* Display the specified resource.
		*/
	public function show(Book $book)
	{
		//
	}

	/**
		* Show the form for editing the specified resource.
		*/
	public function edit(Book $book)
	{
		//
	}

	/**
		* Update the specified resource in storage.
		*/
	public function update(Request $request, Book $book)
	{
		//
	}

	/**
		* Remove the specified resource from storage.
		*/
	public function destroy(Book $book)
	{
		//
	}
}

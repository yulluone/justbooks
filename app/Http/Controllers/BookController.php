<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index()
	{
		$user = Auth::user();

		if ($user && $user->isAdmin) {
			$books = Book::latest()->get();
		} else {
			$books = Book::where('available', true)->latest()->get();
		}

		return Inertia::render('Books/Index', [
			'books' => $books,
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
			'image' => 'required|image'
		]);

		$imageUploadResponse = app(ImageUploadController::class)->uploadImage($request);

		if ($imageUploadResponse->getStatusCode() === 200) {
			$imageData = json_decode($imageUploadResponse->getContent(), true);
			$imageUrl = $imageData['imageUrl']; // Get the image URL
			$validated['image'] = $imageUrl;

			$request->user()->books()->create($validated);

			return redirect(route('books.index'));
		}

		return back()->withErrors(['image' => 'Image upload failed']);

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
	public function update(Request $request, Book $book): RedirectResponse
	{

		$this->authorize('update', $book);

		$validated = $request->validate([
			'name' => "required|string|max:200",
			'publisher' => "required|string|max:50",
			'isbn' => "required|string|max:50",
			'category' => "required|string|max:100",
			'sub_category' => "required|string|max:100",
			'description' => "required|string",
			'pages' => "required|integer|max:2147483648",
			"image" => "required"
		]);

		if ($request->hasFile("image")) {
			$imageUploadResponse = app(ImageUploadController::class)->uploadImage($request);

			if ($imageUploadResponse->getStatusCode() === 200) {
				$imageData = json_decode($imageUploadResponse->getContent(), true);
				$imageUrl = $imageData['imageUrl']; // Get the image URL
				$validated['image'] = $imageUrl;

				$book->update($validated);

				return redirect(route('books.index'));
			}

			return back()->withErrors(['image' => 'Image upload failed']);

		}

		$book->update($validated);
		return redirect(route('books.index'));


	}

	/**
		* Remove the specified resource from storage.
		*/
	public function destroy(Book $book): RedirectResponse
	{
		$this->authorize('delete', $book);

		$book->delete();

		return redirect(route('books.index'));

	}
}

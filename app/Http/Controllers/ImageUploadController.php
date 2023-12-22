<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
	public function uploadImage(Request $request)
	{
		$path = Storage::putFile('images', $request->file('image'));
		$imageUrl = asset($path);

		return response()->json(['imageUrl' => $imageUrl]);
	}
}

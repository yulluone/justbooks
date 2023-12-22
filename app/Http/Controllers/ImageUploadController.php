<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
	public function uploadImage(Request $request)
	{

		$validated = $request->validate([
			'image' => 'required|image'
		]);

		if ($request->hasFile('image')) {
			$path = Storage::putFile('images', $request->file('image'));
			$imageUrl = asset($path);
			return response()->json(['imageUrl' => $imageUrl]);
		}
		return response()->json(['error' => 'Image Upload Failed'], 422);

	}
}

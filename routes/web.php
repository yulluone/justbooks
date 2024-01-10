<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes areR loaded by the outeServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return Inertia::render('Welcome', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
		'laravelVersion' => Application::VERSION,
		'phpVersion' => PHP_VERSION,
	]);
});

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::resource('loans', BookLoanController::class)->only(['index', 'store', 'update']);
	Route::resource('books', BookController::class)->only(['index']);
	Route::put('/loan/extend', [BookLoanController::class, 'extend'])->name('loan.extend');

});

Route::middleware(['auth', 'checkisadmin'])->group(function () {
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::resource('books', BookController::class)
		->only(['store', 'update', 'destroy']);
	Route::resource('users', UserController::class)
		->only(['index', 'updateIsAdmin', 'destroy']);
	// upload image
	Route::post('/upload/image', [ImageUploadController::class, 'uploadImage']);
	Route::put('/loan/approve', [BookLoanController::class, 'approve'])->name('loan.approve');
	Route::put('/loan/deny', [BookLoanController::class, 'deny'])->name('loan.deny');
	Route::put('/loan/receive', [BookLoanController::class, 'receive'])->name('loan.receive');

});



require __DIR__ . '/auth.php';

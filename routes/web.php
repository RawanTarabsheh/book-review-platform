<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\BookController;
use App\Http\Controllers\admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/register', [AuthController::class, 'showRegistrationForm']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('/admin/')->group(function(){
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('generate-pdf', [AdminController::class, 'generatePDF'])->name('generatePDF');
    Route::get('generate-excel', [AdminController::class, 'generateEXCEL'])->name('generateEXCEL');
    Route::get('users', [AdminController::class, 'getUsers'])->name('getUsers');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/history', [BookController::class, 'history'])->name('books.history');
    Route::post('/books/{id}/submit-review', [BookController::class, 'submitReview'])->name('books.submitReview');
    Route::post('/books/{id}/rate', [BookController::class, 'rateBook'])->name('books.rateBook');
    Route::get('/user/history', [BookController::class, 'userHistory'])->name('user.history')->middleware('auth');
});

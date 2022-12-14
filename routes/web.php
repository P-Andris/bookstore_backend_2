<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Copy;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//ADMIN
Route::middleware( ['admin'])->group(function () {
    //books
    // Route::get('/api/books', [BookController::class, 'index']);
    // Route::get('/api/books/{id}', [BookController::class, 'show']);
    // Route::post('/api/books', [BookController::class, 'store']);
    // Route::put('/api/books/{id}', [BookController::class, 'update']);
    // Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
    //copies
    Route::apiResource('/api/copies', CopyController::class);
    //queries
    Route::get('/api/book_copies/{title}', [BookController::class, 'bookCopies']);
    //view - copy
    Route::get('/copy/new', [CopyController::class, 'newView']);
    Route::get('/copy/edit/{id}', [CopyController::class, 'editView']);
    Route::get('/copy/list', [CopyController::class, 'listView']); 
});

// LIBRARIAN
Route::middleware(['librarian'])->group(function() {
    //books
    Route::get('/api/books', [BookController::class, 'index']);
    Route::get('/api/books/{id}', [BookController::class, 'show']);
    Route::post('/api/books', [BookController::class, 'store']);
    Route::put('/api/books/{id}', [BookController::class, 'update']);
    Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
});

//SIMPLE USER
Route::middleware(['auth.basic'])->group(function () {
    //user
    Route::apiResource('/api/users', UserController::class);
    Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
    //queries
    //user lendings
    Route::get('/api/user_lendings', [LendingController::class, 'userLendingsList']);
    Route::get('/api/user_lendings_count', [LendingController::class, 'userLendingsCount']);

    // Route::get('/api/count_reservation/{id}', [ReservationController::class, 'countReservation']);
    Route::get('/api/older/{day}', [ReservationController::class, 'older']);
    Route::get('/api/reservation_count', [ReservationController::class, 'reservationCount']);
    Route::get('/api/authors_books', [BookController::class, 'authorBooks']);
    Route::get('/api/authors_min/{number}', [BookController::class, 'authorsMin']);
    Route::get('/api/authors_b', [BookController::class, 'authorsB']);
    Route::get('/api/authors_start_with/{char}', [BookController::class, 'authorsStartsWith']);
    Route::get('/api/lending_min/{db}', [LendingController::class, 'lendingMin']);

    Route::get('api/my_books', [LendingController::class, 'myBooks']);

    // 2023.01.10.
    Route::patch('/api/bringBack/{copy}/{start}', [LendingController::class, 'bringBack']);
});

//csak a tesztel??s miatt van "kint"
Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
Route::apiResource('/api/copies', CopyController::class);
Route::get('/api/lendings', [LendingController::class, 'index']); 
Route::get('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
Route::put('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::patch('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::post('/api/lendings', [LendingController::class, 'store']);
Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);
//feladatok:
Route::get('/api/book_copies_count/{title}',[CopyController::class, 'bookCopyCount']);
Route::get('/api/hardcoveredCopies/{hardcovered}',[CopyController::class, 'hardcoveredCopies']);
Route::get('/api/givenYear/{year}', [CopyController::class, 'givenYear']);
Route::get('/api/inStock/{status}',[CopyController::class, 'inStock']);
Route::get('/api/checkBook/{book_id}/{year}',[CopyController::class, 'bookCheck']);
Route::get('/api/dataDB/{book_id}',[CopyController::class, 'lendingsDataDB']);
Route::get('/api/dataWT/{book_id}',[CopyController::class,'lendingsDataWT']);

// A lek??rdez??s mindig GET-es
Route::get('/api/list_all/{ev}', [CopyController::class, 'listAll']);

// Reservation v??gpontok:
Route::get('/api/reservations', [ReservationController::class, 'index']);

// MailController:
Route::get('send-mail', [MailController::class, 'index']);

// F??jlfelt??lt??s:
Route::get('file_upload', [FileController::class, 'index']);
Route::post('file_upload', [FileController::class, 'store'])->name('file.store');

Route::delete('/api/reserv_delete', [ReservationController::class, 'deleteOldReservs']);

// Delete user
Route::delete('api/delete_user', [UserController::class, 'deleteUser']);

require __DIR__.'/auth.php';
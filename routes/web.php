<?php


use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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


// Common Resource

// index - Show all Listings
// Show  - Single listing
// create - Show form to create new listing
// store - Store new listing
// edit - SHow form to edit listing
// put - Update listing
// destroy - Delete listing


//Show All Listings

Route::get('/', [ListingController::class, 'index']);

// Show create Listing form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
// Add new Listing
Route::post('/listings/', [ListingController::class, 'store'])->middleware('auth');

// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Show edit form
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage']);
// Show user registration form

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// register new user
Route::post('/users', [UserController::class, 'store']);
// logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
// login user
Route::get('/user/authenticate', [UserController::class, 'authenticate']);

// Show create from
Route::get('/listings/{listing}', [ListingController::class, 'show']);
<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use GuzzleHttp\Middleware;

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

// Show all listings
Route::get('/', [ListingController::class, 'index']);

// Show create form
Route::get('/listings', [ListingController::class, 'create'])->middleware('auth');

// Store new listing
Route::post('/listings/store', [ListingController::class, 'store'])->middleware('auth');

// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Show single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Store user
Route::post('/user', [UserController::class, 'store'])->middleware('guest');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// User authentication
Route::post('/user/authenticate', [UserController::class, 'authenticate'])->middleware('guest');

// Route::get('/hello', function () {
//     return response('<h1>Hello World</h1>')
//         ->header('Content-Type', 'text/plain')
//         ->header('foo', 'bar');
// });

// Route::get('/post/{id}', function ($id) {
//     return response('post ' . $id);
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     return ($request->name . ' is from ' . $request->city);
// });

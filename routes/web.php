<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\SignupController;
use Illuminate\Support\Facades\Route;

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


// show signin page
Route::view('/', 'auth/signin');

// show signup page
Route::view('/signup', 'auth/signup');

// signup route
Route::post('/formsubmit', [SignupController::class, 'signupsave']);

// login check route
Route::post('/logincheck', [LoginController::class, 'logincheck']);

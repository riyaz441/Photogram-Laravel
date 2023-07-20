<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\auth\AdminLoginController;
use App\Http\Controllers\auth\AdminRegisterController;
use App\Http\Controllers\auth\ChangePasswordController;
use App\Http\Controllers\auth\ForgotController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\SignupController;
use App\Http\Controllers\PhotoUploadController;
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

// home page route
Route::view('/home', 'home');

// show forgot password page
Route::view('/forgotpassword', 'auth/forgotpassword');

// forgot password route
Route::post(
    '/forgotpassword',
    [ForgotController::class, 'forgotcheck']
);

// show change password page
Route::view('/changepassword', 'auth/changepassword');

// change password route
Route::post('/changepassword', [ChangePasswordController::class, 'changepassword']);

// logout route
Route::get('/logout', [LoginController::class, 'logout']);

// show admin login page
Route::view('/adminlogin', 'auth/adminlogin');

// admin login route
Route::post('/adminlogincheck', [AdminLoginController::class, 'adminlogin']);


// show admin register page
Route::view('/adminregister', 'auth/adminregister');

// admin register route
Route::post('/adminregistersubmit', [AdminRegisterController::class, 'adminregister']);

// show admin dashboard
Route::view('/admindashboard', 'admindashboard');

// admin dashboard route
Route::get('/admindashboardview', [AdminDashboardController::class, 'admindashboard']);

// admin logout route
Route::get('/adminlogout', [AdminLoginController::class, 'logout']);

// block and unblock route
Route::post('/accountstatus', [AdminDashboardController::class, 'accountstatus']);

// photo upload route
Route::post('/photoupload', [PhotoUploadController::class, 'photoupload']);

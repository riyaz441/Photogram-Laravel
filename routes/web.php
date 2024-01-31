<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\auth\AdminLoginController;
use App\Http\Controllers\auth\AdminRegisterController;
use App\Http\Controllers\auth\ChangePasswordController;
use App\Http\Controllers\auth\ForgotController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\SignupController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeViewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PhotoUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\AccountDeleteController;
use App\Models\Signup;
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

// this middleware protect the browser back button
Route::group(['middleware' => 'prevent-back-history'], function () {

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

    // homeview route
    Route::get('/homeview', [HomeViewController::class, 'homeview']);

    // profile update route
    Route::post('/profileupdate', [ProfileController::class, 'profile']);

    // profile change route
    Route::post('/profilechange', [ProfileController::class, 'profilechange']);

    // google oauth route
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
    Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

    // user feedback route
    Route::post('/userfeedback', [FeedbackController::class, 'userfeedback']);

    // admin feedback route
    Route::view('/adminfeedback', 'adminfeedback');

    // view profile
    Route::view('/viewprofile/{username}', 'viewprofile');

    // search route
    Route::post('/search', [SearchController::class, 'usersearch']);

    // user click the search result route
    Route::get('/viewprofilee/{id}', [SearchController::class, 'user']);

    //post edit route
    Route::post('/postedit', [PhotoUploadController::class, 'postedit']);

    //post update route
    Route::post('/postupdate', [PhotoUploadController::class, 'postupdate']);

    // get delete id route
    Route::post('/postdelete', [PhotoUploadController::class, 'postdelete']);

    // post delete route
    Route::post('/postdeletefinal', [PhotoUploadController::class, 'postdeletefinal']);

    // share show page route
    Route::view('/sharepage/{id}', 'sharepostshow');

    // main home route
    Route::view('/mainhome', 'mainhome');

    // like route
    Route::post('/postlike', [LikeController::class, 'postlike']);

    // follow route
    Route::post('/follow', [FollowController::class, 'follow']);

    // account delete route
    Route::post('/accountdelete', [AccountDeleteController::class, 'accountdelete']);
});

<?php

namespace App\Http\Controllers\auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Signup;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {

        $google_user = Socialite::driver('google')->user();


        $check_google_id = Signup::where('google_id', $google_user->id)->pluck('profile_update_status')->first();

        if ($check_google_id == "") {

            $user = new Signup;

            $user->username = $google_user->name;
            $user->email = $google_user->email;
            $user->google_id = $google_user->id;

            session()->put('google_id', $google_user->id);
            $sess_google_id = session('google_id');

            $user->save();

            // get primary id using google id for google login uesr
            $get_user_id = Signup::where('google_id', '=', $sess_google_id)->first('id');
            session()->put('user_id', $get_user_id['id']);
            session('user_id');

            return redirect('/homeview');
        } else {

            session()->put('google_id', $google_user->id);
            $sess_google_id = session('google_id');

            $get_user_id = Signup::where('google_id', '=', $sess_google_id)->first('id');
            session()->put('user_id', $get_user_id['id']);
            session('user_id');

            return redirect('/homeview');
        }
    }
}

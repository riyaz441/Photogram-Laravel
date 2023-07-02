<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function logincheck(Request $request)
    {
        // return $request->post();
        // exit;

        $email = $request->input('email');
        $password = $request->input('password');

        // session
        $data = $request->input();
        $request->session()->put('email', $data['email']);
        //echo session('email');


        // check deleted or not
        $delete = Signup::where('email', '=', $email)->get('deleted');
        foreach ($delete as $del) {
            if ($del->deleted == 1) {
                return response()->json(['status' => 1]);
            }
        }

        // check login
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return response()->json(['login_status' => 0]);
        } else {
            return response()->json(['login_status' => 1]);
        }
    }
}

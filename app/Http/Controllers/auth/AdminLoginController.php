<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function adminlogin(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $username = $request->input('username');
            $password = $request->input('password');

            // check login
            if (Auth::guard('adminuser')->attempt(['username' => $username, 'password' => $password])) {
                // Authentication passed...
                return response()->json(['login_status' => 0]);
            } else {
                return response()->json(['login_status' => 1]);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/adminlogin');
    }
}

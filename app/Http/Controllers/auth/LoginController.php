<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    public function logincheck(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $email = $request->input('email');
            $password = $request->input('password');

            // rememberme check
            if ($request->has('rememberme')) {
                Cookie::queue('email', $email, 1440);
                Cookie::queue('userpassword', $password, 1440);
            }


            // check deleted or not
            $delete = Signup::where('email', '=', $email)->get('deleted');
            foreach ($delete as $del) {
                if ($del->deleted == 1) {
                    return response()->json(['status' => 1]);
                }
            }

            // check account blocked or not
            $blocked_status = Signup::where('email', '=', $email)->get('active_status');
            foreach ($blocked_status as $accstatus) {
                if ($accstatus->active_status == 1) {
                    return response()->json(['block_status' => 1]);
                }
            }

            // check login
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // session
                $data = $request->input();
                $request->session()->put('email', $data['email']);
                $session_email = session('email');
                $get_user_id = Signup::where('email', '=', $session_email)->first('id');
                session()->put('user_id', $get_user_id['id']);
                session('user_id');
                //echo session('email');

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
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Signup;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function signupsave(Request $request)
    {

        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'mobile' => 'required|numeric|max:10'
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $username = $request->input('username');
            $email = $request->input('email');
            $password = Hash::make($request->input('password'));
            $mobile = $request->input('mobile');

            $signupsave = new Signup;

            $signupsave->username = $username;
            $signupsave->email = $email;
            $signupsave->password = $password;
            $signupsave->mobile = $mobile;

            try {
                $signupsave->save();
                return ['message' => '0'];
            } catch (\Throwable $e) {
                return ['message' => $e->getCode()];
            }
        }
    }
}

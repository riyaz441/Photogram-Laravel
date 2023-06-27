<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Signup;

class SignupController extends Controller
{
    public function signupsave(Request $request)
    {

        // return $request->post();
        // exit;
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

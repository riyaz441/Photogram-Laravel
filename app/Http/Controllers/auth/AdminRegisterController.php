<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegisterController extends Controller
{
    public function adminregister(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $username = $request->input('username');
            $email = $request->input('email');
            $password = Hash::make($request->input('password'));

            $adminsignupsave = new AdminLogin;

            $adminsignupsave->username = $username;
            $adminsignupsave->email = $email;
            $adminsignupsave->password = $password;

            try {
                $adminsignupsave->save();
                return ['message' => '0'];
            } catch (\Throwable $e) {
                return ['message' => $e->getCode()];
            }
        }
    }
}

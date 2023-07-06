<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changepassword(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $newpassword = Hash::make($request->input('password'));
            $emailSession = session('email');
            Signup::where('email', '=', $emailSession)->update(array('password' => $newpassword));
            return response()->json(['changepassword_status' => 0]);
        }
    }
}

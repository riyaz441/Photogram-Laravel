<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signup;

class AccountDeleteController extends Controller
{
        public function accountdelete (Request $request) {
        // return $request->post();
        // exit;


            $username = $request->input('deleteaccount');
            $user_id = Signup::where('username', $username)->pluck('id')->first();

            // account status change 0 to 1
            Signup::where('id', $user_id)->update(['deleted' => 1]);
            return response()->json(['message' => 0]);

    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function logincheck(Request $request)
    {
        return $request->post();
        exit;
    }
}

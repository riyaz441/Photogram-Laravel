<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function admindashboard()
    {
        $allusers = Signup::all();
        return view('/admindashboard', ['users' => $allusers]);
    }
}

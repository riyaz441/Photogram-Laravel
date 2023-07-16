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

    public function accountstatus(Request $request)
    {
        // return $request->post();
        // exit;
        $id = $request->post('id');
        $status = $request->post('status');

        if ($status == "block") {
            Signup::where('id', '=', $id)->update(array('active_status' => 1));
            $allusers = Signup::all();
            return response()->json($allusers);
        }
        if ($status == "unblock") {
            Signup::where('id', '=', $id)->update(array('active_status' => 0));
            $allusers = Signup::all();
            return response()->json($allusers);
        }
    }
}

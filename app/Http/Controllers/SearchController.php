<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signup;

class SearchController extends Controller
{
    public function usersearch(Request $request)
    {
        $searchkey = $request->input('searchdata');

        if ($searchkey != "") {
            $searchresult = Signup::query()
                ->where('username', 'LIKE', "%{$searchkey}%")
                ->get();

            return response()->json($searchresult);
        } else {
            return response()->json(['message' => 0]);
        }
    }

    public function user($id)
    {
        $userid = $id;

        return view('viewprofilefollow', compact('userid'));
    }
}

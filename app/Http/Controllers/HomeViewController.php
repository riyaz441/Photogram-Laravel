<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Signup;
use Illuminate\Http\Request;

class HomeViewController extends Controller
{
    public function homeview()
    {
        //$usersWithPosts = Photo::where('userid', session('user_id'))->get();


        $usersWithPosts = Photo::select('photos.*')
            ->join('signups', 'signups.id', '=', 'photos.userid')->where('photos.userid', '=', session('user_id'))->where('photos.deleted', '=', 0)
            ->get();
        return view('/home', ['userspost' => $usersWithPosts]);
        // $user = Signup::find(1);
        // dd($user->photo);
    }
}

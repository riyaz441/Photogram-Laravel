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
            ->join('signups', 'signups.id', '=', 'photos.userid')->where('userid', '=', session('user_id'))
            ->get();
        return view('/home', ['userspost' => $usersWithPosts]);
        // $user = Signup::find(1);
        // dd($user->photo);

        // $photo = Photo::find(1);
        // dd($photo);
    }
}

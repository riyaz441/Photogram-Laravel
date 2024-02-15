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

        // $usersWithPosts = Photo::join('signups', 'signups.id', '=', 'photos.userid')->join('likes', 'likes.post_id', '=', 'photos.id')->join('like_button_stages', 'like_button_stages.post_id', '=', 'photos.id')->where('photos.userid', '=', session('user_id'))->where('photos.deleted', '=', 0)
        // ->get(['photos.*', 'likes.like', 'like_button_stages.like_button_stage']);
        // return view('/home', ['userspost' => $usersWithPosts]);


        $usersWithPosts = Photo::join('signups', 'signups.id', '=', 'photos.userid')->join('likes', 'likes.post_id', '=', 'photos.id')->where('photos.userid', '=', session('user_id'))->where('photos.deleted', '=', 0)->orderBy('id', 'desc')
            ->get(['photos.*', 'likes.like']);
        return view('/home', ['userspost' => $usersWithPosts]);
        // $user = Signup::find(1);
        // dd($user->photo);
    }
}

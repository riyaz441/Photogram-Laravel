<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Photo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function postlike(Request $request)
    {
        // return $request->post();
        // exit;


        $post_id = $request->input('id');



        // check user id exist array or not
        $post_like_count = Likes::where('post_id', $post_id)
            ->pluck('liked_user')
            ->first();


        if (in_array(session('user_id'), $post_like_count)) {

            $like_count = Likes::where('post_id', $post_id)->pluck('like')->first();
            $like_count_final = $like_count - 1;

            // get like primary id
            $get_like_id = Likes::where('post_id', $post_id)->pluck('id')->first();

            Likes::where('id', $get_like_id)->update(['like' => $like_count_final]);

            $key = array_search(session('user_id'), $post_like_count);

            if ($key !== false) {
                unset($post_like_count[$key]);
            }

            Likes::where('id', $get_like_id)->update(['liked_user' => $post_like_count]);
            return response()->json(['message' => 0]);
        } else {

            $like_count = Likes::where('post_id', $post_id)->pluck('like')->first();
            $like_count_final = $like_count + 1;

            // get like primary id
            $get_like_id = Likes::where('post_id', $post_id)->pluck('id')->first();

            Likes::where('id', $get_like_id)->update(['like' => $like_count_final]);

            array_push($post_like_count, session('user_id'));
            Likes::where('id', $get_like_id)->update(['liked_user' => $post_like_count]);

            return response()->json(['message' => 1]);
        }
    }
}

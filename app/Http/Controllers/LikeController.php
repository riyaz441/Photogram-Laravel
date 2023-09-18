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

        // get like count
        $post_like_count = Likes::where('post_id', $post_id)->where('user_id', session('user_id'))
            ->pluck('like')
            ->first();


        // check liked or not
        if ($post_like_count == "" || $post_like_count == 0) {
            // not liked

            $like_count = Likes::where('post_id', $post_id)->pluck('like')->first();
            $like_count_final = $like_count + 1;

            // get like primary id
            $get_like_id = Likes::where('post_id', $post_id)->pluck('id')->first();

            Likes::where('id', $get_like_id)->update(['like' => $like_count_final]);

            return response()->json(['message' => 0]);
        } else {
            // liked

            $like_count = Likes::where('post_id', $post_id)->pluck('like')->first();
            $like_count_final = $like_count - 1;

            // get like primary id
            $get_like_id = Likes::where('post_id', $post_id)->pluck('id')->first();

            Likes::where('id', $get_like_id)->update(['like' => $like_count_final]);


            return response()->json(['message' => 1]);
        }


        //$updated_like_count = $post_like_count + 1;

        // Photo::where('id', $post_id)->update(['like' => $updated_like_count]);
        // return response()->json(['message' => 0]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Like_button_stage;

class LikeController extends Controller
{
    public function postlike(Request $request)
    {
        // return $request->post();
        // exit;


        $post_id = $request->input('id');


        // button stage update code start
        $post_like_button_stage = Like_button_stage::where('post_id', $post_id)->where('user_id', session('user_id'))
            ->pluck('like_button_stage')
            ->first();


        // user like first time check empty condition
        if ($post_like_button_stage == "") {
            //save button stage
            $like_button_stage = new Like_button_stage;

            $like_button_stage->user_id = session('user_id');
            $like_button_stage->post_id = $post_id;
            $like_button_stage->like_button_stage = 0;
            $like_button_stage->save();
        }


        // update like button stage
        if ($post_like_button_stage == 0) {
            // update data in like table

            // get like primary id
            $get_like_id = Like_button_stage::where('post_id', $post_id)->where('user_id', session('user_id'))->pluck('id')->first();

            Like_button_stage::where('id', $get_like_id)->update(['like_button_stage' => 1]);
        } else {

            // get like primary id
            $get_like_id = Like_button_stage::where('post_id', $post_id)->where('user_id', session('user_id'))->pluck('id')->first();

            Like_button_stage::where('id', $get_like_id)->update(['like_button_stage' => 0]);
        }

        // button stage update code end



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

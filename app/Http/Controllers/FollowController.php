<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follow_user_table;
use App\Models\Follower_count;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        // return $request->post();
        // exit;

        $user_get_id = $request->input('followdata');


        ////////////////////////////////////////////////////   set 1 start (followers sub table work)    ////////////////////////////////////////////////////

        // check record already exists or not is followers table
        $followers_stage = Follower_count::where('follower_user_id', $user_get_id)
            ->pluck('follower_count')
            ->first();


        // insert new record in follow table
        if ($followers_stage == "") {
            // save data in like table
            $follower = new Follower_count;

            // Create an array
            $dataArray = [];

            $follower->user_id = $dataArray;
            $follower->follower_user_id = $user_get_id;
            $follower->follower_count = 0;
            $follower->save();
        }


        // check user id exist array or not (followers main array)
        $post_followers_count = Follower_count::where('follower_user_id', $user_get_id)
            ->pluck('user_id')
            ->first();


        if (in_array(session('user_id'), $post_followers_count)) {
            $follow_count = Follower_count::where('follower_user_id', $user_get_id)->pluck('follower_count')->first();
            $follow_count = $follow_count - 1;

            // get like primary id
            $get_followers_id = Follower_count::where('follower_user_id', $user_get_id)->pluck('id')->first();

            // update follow count
            Follower_count::where('id', $get_followers_id)->update(['follower_count' => $follow_count]);

            // remove element in array
            $key = array_search(session('user_id'), $post_followers_count);

            if ($key !== false) {
                unset($post_followers_count[$key]);
            }

            // final update array
            Follower_count::where('id', $get_followers_id)->update(['user_id' => $post_followers_count]);
        } else {
            $follow_count = Follower_count::where('follower_user_id', $user_get_id)->pluck('follower_count')->first();
            $follow_count = $follow_count + 1;

            // get like primary id
            $get_followers_id = Follower_count::where('follower_user_id', $user_get_id)->pluck('id')->first();

            // update follow count
            Follower_count::where('id', $get_followers_id)->update(['follower_count' => $follow_count]);

            // add new element in array
            array_push($post_followers_count, session('user_id'));


            // final update array
            Follower_count::where('id', $get_followers_id)->update(['user_id' => $post_followers_count]);
        }


        ////////////////////////////////////////////////////   set 1 end (followers sub table work)    ////////////////////////////////////////////////////



        ////////////////////////////////////////////////////   set 2 start (follow main table work)    ////////////////////////////////////////////////////

        // check entry in follow table
        $follow_stage = follow_user_table::where('user_id', session('user_id'))
            ->pluck('follow_count')
            ->first();


        if ($follow_stage == "") {
            // save data in like table
            $follow = new follow_user_table;

            // Create an array
            $dataArray = [];

            $follow->user_id = session('user_id');
            $follow->follow_count = 0;
            $follow->follow_user_id = $dataArray;
            $follow->save();
        }

        // check user id exist array or not (main array)
        $post_follow_count = follow_user_table::where('user_id', session('user_id'))
            ->pluck('follow_user_id')
            ->first();


        if (in_array($user_get_id, $post_follow_count)) {
            $follow_count = follow_user_table::where('user_id', session('user_id'))->pluck('follow_count')->first();
            $follow_count = $follow_count - 1;

            // get like primary id
            $get_follow_id = follow_user_table::where('user_id', session('user_id'))->pluck('id')->first();

            // update follow count
            follow_user_table::where('id', $get_follow_id)->update(['follow_count' => $follow_count]);

            // remove element in array
            $key = array_search($user_get_id, $post_follow_count);

            if ($key !== false) {
                unset($post_follow_count[$key]);
            }

            // final update array
            follow_user_table::where('id', $get_follow_id)->update(['follow_user_id' => $post_follow_count]);

            return response()->json(['message' => 0]);
        } else {
            $follow_count = follow_user_table::where('user_id', session('user_id'))->pluck('follow_count')->first();
            $follow_count = $follow_count + 1;

            // get like primary id
            $get_follow_id = follow_user_table::where('user_id', session('user_id'))->pluck('id')->first();

            // update follow count
            follow_user_table::where('id', $get_follow_id)->update(['follow_count' => $follow_count]);

            // add new element in array
            array_push($post_follow_count, $user_get_id);

            // final update the array
            follow_user_table::where('id', $get_follow_id)->update(['follow_user_id' => $post_follow_count]);

            return response()->json(['message' => 1]);
        }


        ////////////////////////////////////////////////////   set 2 end (follow main table work)    ////////////////////////////////////////////////////
    }
}

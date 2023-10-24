<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follow_user_table;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        // return $request->post();
        // exit;

        $user_get_id = $request->input('followdata');

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
    }
}

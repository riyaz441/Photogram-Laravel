<?php

namespace App\Http\Controllers;

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
        $post_like_count = Photo::where('id', $post_id)
            ->pluck('like')
            ->first();

        $updated_like_count = $post_like_count + 1;

        // Photo::where('id', $post_id)->update(['like' => $updated_like_count]);
        // return response()->json(['message' => 0]);
    }
}

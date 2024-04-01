<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Profile;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class CommentController extends Controller
{
    public function usercomment(Request $request)
    {

        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        // this if code check user first time comment or update the comment
        if ($request->input('commentid') == "") {   // new comment
            // first time comment
            if (!$validator->passes()) {
                return response()->json([
                    'status' => 0, 'error' => $validator->errors()->toArray()
                ]);
            } else {
                $usercomment = strip_tags($request->input('comment'));
                $postid = strip_tags(Crypt::decryptString($request->input('postid')));

                // create new object
                $comment = new comment;

                $comment->userid = session('user_id');
                $comment->postid = $postid;
                $comment->comment = $usercomment;
                $comment->save();
                return ['message' => 0];
            }
        } else {    // update comment
            if (!$validator->passes()) {
                return response()->json([
                    'status' => 0, 'error' => $validator->errors()->toArray()
                ]);
            } else {
                $comment_id = $request->post('commentid');
                $usercomment = strip_tags($request->input('comment'));

                Comment::where('id', $comment_id)->update(['comment' => $usercomment]);
                return ['message' => 0];
            }
        }
    }

    public function getcomments(Request $request)
    {
        // return $request->post();
        // exit;

        $get_comment_postid = Crypt::decryptString($request->input('postid'));

        // model query
        $get_all_user_comments = Comment::select('comments.id', 'comments.userid', 'comments.comment', 'comments.created_at', 'profiles.profile_photo', 'signups.username')
            ->join('profiles', 'comments.userid', '=', 'profiles.userid')
            ->join('signups', 'profiles.userid', '=', 'signups.id')
            ->where('comments.postid', $get_comment_postid)
            ->where('comments.deleted', 0)
            ->where('profiles.deleted', 0)
            ->where('signups.deleted', 0)
            ->where('comments.reported', '<', 5)
            ->get()
            ->map(function ($comment) {
                $comment->created_at_human = $comment->created_at->diffForHumans();
                return $comment;
            });

        // You can now iterate through $results to access the retrieved data
        return response()->json($get_all_user_comments); // Return data as JSON
    }

    public function commentedit(Request $request)
    {
        // return $request->post();
        // exit;

        $id = $request->input('id');

        $comment_edit_details = Comment::where('id', $id)->first();

        $comment_id = $comment_edit_details->id;
        $comment = $comment_edit_details->comment;

        return response()->json(['id' => $comment_id, 'comment' => $comment]);
    }

    public function commentdelete(Request $request)
    {
        // return $request->post();
        // exit;

        $id = $request->input('id');
        $comment_delete_details = Comment::where('id', $id)->first();
        $uid = $comment_delete_details->id;

        return response()->json(['id' => $uid]);
    }

    public function commentdeletefinal(Request $request)
    {
        // return $request->post();
        // exit;

        $udcid = $request->input('udcid');

        Comment::where('id', $udcid)->update(['deleted' => 1]);
        return response()->json(['message' => 0]);
    }
}

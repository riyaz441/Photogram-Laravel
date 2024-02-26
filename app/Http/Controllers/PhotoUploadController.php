<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Signup;
use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoUploadController extends Controller
{
    public function photoupload(Request $request)
    {
        //return $request->all();
        // $image = $request->file('photo');
        // echo $image;
        // echo session('user_id');
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5000'
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // get input from user
            $caption = strip_tags($request->input('caption'));
            //$imagePath = $request->file('photo')->storeAs('user_images', 'public');

            // image upload process
            $image = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $image, 'public');
            $finalimage = '/storage/' . $path;

            // main table
            $user = new Signup();

            // sub table
            $userImage = new Photo();
            $userImage->userid = session('user_id');
            $userImage->caption = $caption;
            $userImage->photo = $finalimage;
            $userImage->save();

            // save data in like table
            $like = new Likes;

            // Create an array
            $dataArray = [];

            $like->user_id = session('user_id');
            $like->post_id = $userImage->id;
            $like->like = 0;
            $like->liked_user = $dataArray;
            $like->save();

            return response()->json(['message' => 0]);
        }
    }

    public function postedit(Request $request)
    {
        $id = $request->input('id');

        $post_edit_details = Photo::where('id', $id)->first();

        $uid = $post_edit_details->id;
        $uphoto = $post_edit_details->photo;
        $ucaption = $post_edit_details->caption;

        return response()->json(['id' => $uid, 'photo' => $uphoto, 'caption' => $ucaption]);
    }

    public function postupdate(Request $request)
    {
        // return $request->post();
        // exit;
        // $image = $request->file('postphoto');
        // echo $image;
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'postphoto' => 'image|mimes:jpeg,png,jpg|max:5000'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $caption = strip_tags($request->input('caption'));
            $uid = $request->input('uid');

            Photo::where('id', $uid)->update(['caption' => $caption]);

            $postimage = $request->file('postphoto');

            if ($postimage != "") {
                $postimage = $request->file('postphoto')->getClientOriginalName();
                $path = $request->file('postphoto')->storeAs('profileimages', $postimage, 'public');
                $finalprofileimage = '/storage/' . $path;

                Photo::where('id', $uid)->update(['photo' => $finalprofileimage]);
                return response()->json(['message' => 0]);
            }

            return response()->json(['message' => 0]);
        }
    }

    public function postdelete(Request $request)
    {
        // return $request->post();
        // exit;

        $id = $request->input('id');

        $post_delete_details = Photo::where('id', $id)->first();

        $uid = $post_delete_details->id;

        return response()->json(['id' => $uid]);
    }

    public function postdeletefinal(Request $request)
    {
        // return $request->post();
        // exit;

        $udid = $request->input('udid');

        Photo::where('id', $udid)->update(['deleted' => 1]);
        return response()->json(['message' => 0]);
    }
}

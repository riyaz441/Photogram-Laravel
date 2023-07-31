<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        // return $request->post();
        // exit;
        // $image = $request->file('profilephoto');
        // echo $image;

        // server side validation
        $validator = Validator::make($request->all(), [
            'profilephoto' => 'image|mimes:jpeg,png,jpg|max:5000'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $about = $request->input('about');
            $gender = $request->input('gender');

            // upload user profile picture
            $image = $request->file('profilephoto')->getClientOriginalName();
            $path = $request->file('profilephoto')->storeAs('profileimages', $image, 'public');
            $finalprofileimage = '/storage/' . $path;

            $profile = new Profile;
            $profile->userid = session('user_id');
            $profile->about = $about;
            $profile->gender = $gender;
            $profile->profile_photo = $finalprofileimage;
            $profile->save();
            return response()->json(['message' => 0]);
        }
    }
}

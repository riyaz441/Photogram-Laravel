<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\Signup;

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
            $about = strip_tags($request->input('about'));
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

            // profile update flag make 1
            Signup::where('id', session('user_id'))->update(['profile_update_status' => 1]);

            return response()->json(['message' => 0]);
        }
    }

    public function profilechange(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'profilephoto' => 'image|mimes:jpeg,png,jpg|max:5000'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $about = strip_tags($request->input('about'));
            $gender = $request->input('gender');

            Profile::where('userid', session('user_id'))->update(['about' => $about, 'gender' => $gender]);

            $image = $request->file('profilephoto');

            if ($image != "") {
                // upload user profile picture
                $image = $request->file('profilephoto')->getClientOriginalName();
                $path = $request->file('profilephoto')->storeAs('profileimages', $image, 'public');
                $finalprofileimage = '/storage/' . $path;

                Profile::where('userid', session('user_id'))->update(['profile_photo' => $finalprofileimage]);
                return response()->json(['message' => 0]);
            }

            return response()->json(['message' => 0]);
        }
    }
}

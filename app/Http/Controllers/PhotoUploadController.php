<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Signup;
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
            $caption = $request->input('caption');
            $imagePath = $request->file('photo')->store('user_images');
            // main table
            $user = new Signup();

            // sub table
            $userImage = new Photo();
            $userImage->userid = session('user_id');
            $userImage->caption = $caption;
            $userImage->photo = $imagePath;
            $userImage->save();
            return response()->json(['message' => 0]);
        }
    }
}

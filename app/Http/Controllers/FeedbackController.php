<?php

namespace App\Http\Controllers;

use App\Models\user_feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function userfeedback(Request $request)
    {
        // server side validation
        $validator = Validator::make($request->all(), [
            'feedback' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $userfeedback = $request->input('feedback');

            $feedback = new user_feedback;

            $feedback->userid = session('user_id');
            $feedback->feedback = $userfeedback;
            $feedback->deleted = 0;
            $feedback->save();
            return ['message' => 0];
        }
    }
}

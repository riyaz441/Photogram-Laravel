<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotController extends Controller
{
    public function forgotcheck(Request $request)
    {
        // return $request->post();
        // exit;

        // server side validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {

            $email = $request->input('email');

            // session email
            $data = $request->input();
            $request->session()->put('email', $data['email']);
            //echo Session('email');

            $useremail = Signup::where('email', '=', $email)->first();
            if ($useremail === null) {
                return response()->json(['forgotpasswordstatus' => 1]);
            } else {
                // send email
                $to = $email;
                $subject = 'Forgot Password Mail';
                $from = 'rm15324950@gmail.com';

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                    'Reply-To: ' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html><body>';
                $message .= '<h2 style="color:#010101;">Forgot Password</h2>';
                $message .= '<p style="color:#010101;"><a href="http://127.0.0.1:8000/changepassword">Click Here!</a></p>';
                $message .= '</body></html>';

                // Sending email
                if (mail($to, $subject, $message, $headers)) {
                    return response()->json(['mailsentstatus' => 0]);
                } else {
                    return response()->json(['mailsentstatus' => 1]);
                }
            }
        }
    }
}

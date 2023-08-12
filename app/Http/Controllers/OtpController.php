<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;

class OtpController extends Controller
{
    function index() {
        $user = json_decode(base64_decode(request()->user));
        return view('auth.otp',compact('user'));
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'otp' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        // Initialize Firebase Authentication
        $factory = (new Factory)->withServiceAccount(__DIR__.'/../../../storage/app/'.env("GOOGLE_APPLICATION_CREDENTIALS"));
        $auth = $factory->createAuth();

        // auth refresh token
        $idTokenString = $request->token;

        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) {
            echo 'The token could not be parsed: '.$e->getMessage();
        } catch (Exception $e) {
            echo 'The token is invalid: '.$e->getMessage();
        }
        $claims = $verifiedIdToken->claims();
        $uid = $claims->get('user_id');
        $user = $auth->getUser($uid);
        

        $checkUser = User::where(['no_hp' => (int)$user->phoneNumber])->first();
        Auth::login($checkUser);
        return redirect()->route('auth.dashboard');
    }
}

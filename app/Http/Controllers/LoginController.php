<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function post(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'no_hp' => 'required',
            'password' => 'required|min:6'
        ]);
        $no_hp = $request->no_hp;
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        if (substr($no_hp, 0, 1) == '0') {
            $no_hp = '+62' . substr($no_hp, 1);
        }

        $user = User::where(['no_hp' => (int) $no_hp])->first();
        //validate password
        if (!$user || !password_verify($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'password' => ['The provided credentials are incorrect.']
            ]);
        }

        return redirect()->route('auth.otp', [
            'user' => base64_encode(json_encode([
                'no_hp' => $no_hp,
                'name' => $user->name,
            ]))
        ]);
    }
}
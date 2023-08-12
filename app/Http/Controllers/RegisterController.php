<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;

class RegisterController extends Controller
{
    function index() {
        return view('auth.register');
    }

    function post(Request $request) {
       

        $validator = Validator::make($request->all(), [
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed',
            'name'=>'required',
            'password_confirmation'=>'required|min:6'
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 403);
            } else {
                return redirect()->back()->withErrors($validator->errors());
            }
            
        }

        DB::beginTransaction();

        try {
            $name = $request->name;
            $no_hp = $request->no_hp;
            $password = $request->password;
            $password_confirmation = $request->password_confirmation;


            // format no_hp to +62
            if (substr($no_hp, 0, 1) == '0') {
                $no_hp = '+62' . substr($no_hp, 1);
            }

            $user = new User;
            $user->name = $name;
            $user->no_hp = $no_hp;
            $user->password = $password;
            //$user->verification_id = $verificationId;
            $user->save();
            DB::commit();
            //check ajax
            if ($request->ajax()) {
                return response()->json(['user' => base64_encode(json_encode([
                    'no_hp' => $no_hp,
                    'name' => $name,
                ]))], 200);
            } else {
                return redirect()->route('auth.otp', ['user' => base64_encode(json_encode([
                    'no_hp' => $no_hp,
                    'name' => $name,
                ]))]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            if ($request->ajax()) {
                return response()->json(['errors' => $th->getMessage()], 403);
            } else {
                return redirect()->back()->withErrors($th->getMessage());
            }
        }

    }
}

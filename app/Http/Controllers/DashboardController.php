<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('auth.dashboard');
    }

    //logout    
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('auth.login');
    }
}

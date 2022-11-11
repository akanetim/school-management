<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //controller are here

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}

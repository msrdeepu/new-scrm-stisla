<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function login()
    {
        return view('superadmin.auth.login');
    }
}

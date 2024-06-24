<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class SuperadminController extends Controller
{
    public function dashboard()
    {
        $messages = Message::latest()->paginate(25);

        //dd($messages);
        return view('superadmin.dashboard', compact('messages'));
    }

    public function login()
    {
        return view('superadmin.auth.login');
    }
}

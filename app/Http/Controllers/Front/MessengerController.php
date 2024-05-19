<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessengerController extends Controller
{
    function index(): View
    {
        return view('messenger.index');
    }
}

<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    function index(): View
    {
        return view('messenger.index');
    }

    function search(Request $request)
    {
        // dd($request->all());
        $getRecords = null;
        $user = Auth::user()->id;
        $input = $request['query'];
        // dd($input);
        $records = User::where('id', '!=', $user)
            ->where('name', 'LIKE', "%{$input}%")
            ->orWhere('user_name', 'LIKE', "%{$input}%")
            ->get();

        foreach ($records as $record) {
            $getRecords .= view('messenger.components.search-item', compact('record'))->render();
        }

        return response()->json([
            'records' => $getRecords
        ]);
    }
}

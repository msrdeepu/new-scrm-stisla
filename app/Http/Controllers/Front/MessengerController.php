<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Message;
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
            ->paginate(10);

        if ($records->total() < 1) {
            $getRecords = '<p class="text-center">No Data Available</p>';
        }

        foreach ($records as $record) {
            $getRecords .= view('messenger.components.search-item', compact('record'))->render();
        }

        return response()->json([
            'records' => $getRecords,
            'last_page' => $records->lastPage()
        ]);
    }

    // fetch user by ID
    function fetchIdInfo(Request $request)
    {
        $fetch = User::where('id', $request['id'])->first();

        return response()->json([
            'fetch' => $fetch
        ]);
    }

    function sendMessage(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'message' => ['required'],
            'id' => ['integer', 'required'],
            'temporaryMsgId' => ['required']
        ]);

        // store messages in database
        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;
        $message->save();

        return response()->json([
            'message' => $this->messageCard($message),
            'tempId' => $request->temporaryMsgId
        ]);
    }

    function messageCard($message)
    {
        return view('messenger.components.message-card', compact('message'))->render();
    }
}

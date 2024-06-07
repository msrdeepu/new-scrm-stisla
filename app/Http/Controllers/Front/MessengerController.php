<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Message;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    use FileUploadTrait;
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
            'message' => ['nullable'],
            'id' => ['integer', 'required'],
            'temporaryMsgId' => ['required'],
            'attachment' => ['nullable', 'max:1024', 'image']
        ]);



        // store messages in database
        $attachmentPath = $this->uploadFile($request, 'attachment');




        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;

        if ($attachmentPath) $message->attachment = json_encode($attachmentPath);
        $message->save();

        return response()->json([
            'message' => $message->attachment ? $this->messageCard($message, true) : $this->messageCard($message),
            'tempId' => $request->temporaryMsgId
        ]);
    }

    function messageCard($message, $attachment = false)
    {
        return view('messenger.components.message-card', compact('message', 'attachment'))->render();
    }

    //fetch messeges from database
    public function fetchMessages(Request $request)
    {
        // dd($request->all());
        $messages = Message::where('from_id', Auth::user()->id)->where('to_id', $request->id)
            ->orWhere('from_id', $request->id)->where('to_id', Auth::user()->id)
            ->latest()->paginate(20);
        $response = [
            'last_page' => $messages->lastPage(),
            'messages' => ''
        ];

        //we have to make a little validation

        $allMessages = '';
        foreach ($messages->reverse() as $message) {
            $allMessages .= $this->messageCard($message, $message->attachment ? true : false);
        }

        $response['messages'] = $allMessages;

        return response()->json($response);
    }
}

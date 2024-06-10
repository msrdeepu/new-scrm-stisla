<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Message;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    function fetchMessages(Request $request)
    {
        // dd($request->all());
        $messages = Message::where('from_id', Auth::user()->id)->where('to_id', $request->id)
            ->orWhere('from_id', $request->id)->where('to_id', Auth::user()->id)
            ->latest()->paginate(20);
        $response = [
            'last_page' => $messages->lastPage(),
            'last_message' => $messages->last(),
            'messages' => ''
        ];

        if (count($messages) < 1) {
            $response['messages'] = '<div class="h-100 d-flex flex-row justify-content-center align-items-center"><p class="p-3 badge bg-primary text-bold">Say Hi and start Messaging</p></div>';
            return response()->json($response);
        }

        $allMessages = '';
        foreach ($messages->reverse() as $message) {
            $allMessages .= $this->messageCard($message, $message->attachment ? true : false);
        }

        $response['messages'] = $allMessages;

        return response()->json($response);
    }

    //fetch contacts from database
    function fetchContacts(Request $request)
    {
        // instructor query
        // $users = Message::join('users', function ($join) {
        //     $join->on('messages.from_id', '=', 'users.id')
        //         ->orOn('messages.to_id', '=', 'users.id');
        // })
        //     ->where(function ($q) {
        //         $q->where('messages.from_id', Auth::user()->id)
        //             ->orWhere('messages.to_id', Auth::user()->id);
        //     })
        //     ->where('users.id', '!=', Auth::user()->id)
        //     ->select('users.*', DB::raw('MAX(messages.created_at) max_created_at'))
        //     ->orderBy('max_created_at', 'desc')
        //     ->groupBy('users.id')
        //     ->paginate(10);

        // return $users;

        // instructor query end

        $users = Message::join('users', function ($join) {
            $join->on('messages.from_id', '=', 'users.id')
                ->orOn('messages.to_id', '=', 'users.id');
        })
            ->where(function ($q) {
                $q->where('messages.from_id', Auth::user()->id)
                    ->orWhere('messages.to_id', Auth::user()->id);
            })
            ->where('users.id', '!=', Auth::user()->id)
            ->select('users.id', 'users.name', 'users.email', 'users.avatar', DB::raw('MAX(messages.created_at) as max_created_at'))
            ->orderBy('max_created_at', 'desc')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.avatar')
            ->paginate(10);

        return $users;
    }
}

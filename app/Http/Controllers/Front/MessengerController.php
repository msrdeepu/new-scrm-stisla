<?php

namespace App\Http\Controllers\front;

use App\Events\Message as MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Message;
use App\Models\Favourite;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessengerController extends Controller
{
    use FileUploadTrait;
    function index(): View
    {
        $favoriteList = Favourite::with('user:id,name,avatar')->where('user_id', Auth::user()->id)->get();
        return view('messenger.index', compact('favoriteList'));
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

        $favorite = Favourite::where(['user_id' => Auth::user()->id, 'favourite_id' => $fetch->id])->exists();

        $sharedPhotos = Message::where('from_id', Auth::user()->id)->where('to_id', $request->id)->whereNotNull('attachment')
            ->orWhere('from_id', $request->id)->where('to_id', Auth::user()->id)->whereNotNull('attachment')
            ->latest()->get();

        $content = '';

        foreach ($sharedPhotos as $photo) {
            $content .= view('messenger.components.gallery-item', compact('photo'))->render();
        }

        return response()->json([
            'fetch' => $fetch,
            'favorite' => $favorite,
            'shared_photos' => $content
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

        //broadcast event to send message

        MessageEvent::dispatch($message);

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

        if (count($users) > 0) {
            $contacts = '';
            foreach ($users as $user) {
                $contacts .= $this->getContactItem($user);
            }
        } else {
            $contacts = '<p>Yout Contacts List is Empty</p>';
        }
        return response()->json([
            'contacts' => $contacts,
            'last_page' => $users->lastPage()
        ]);
    }
    function getContactItem($user)
    {
        $lastMessage = Message::where('from_id', Auth::user()->id)->where('to_id', $user->id)
            ->orWhere('from_id', $user->id)->where('to_id', Auth::user()->id)
            ->latest()->first();

        $unseenCounter = Message::where('from_id', $user->id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();


        return view('messenger.components.contact-list-item', compact('lastMessage', 'unseenCounter', 'user'))->render();
    }

    function updateContactItem(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 401);
        }

        $contactItem = $this->getContactItem($user);
        return response()->json([
            'contact_item' => $contactItem
        ]);
    }

    function makeSeen(Request $request)
    {
        Message::where('from_id', $request->id)
            ->where('to_id', Auth::user()->id)
            ->where('seen', 0)
            ->update(['seen' => 1]);
    }


    //add/remove favorite list

    function favorite(Request $request)
    {
        //dd($request->all());
        $query = Favourite::where(['user_id' => Auth::user()->id, 'favourite_id' => $request->id]);
        $favoriteStatus = $query->exists();

        if (!$favoriteStatus) {
            $star = new Favourite();
            $star->user_id = Auth::user()->id;
            $star->favourite_id = $request->id;
            $star->save();

            return response(['status' => 'added']);
        } else {
            $query->delete();

            return response(['status' => 'removed']);
        }
    }


    //delete message
    function deleteMessage(Request $request)
    {
        $message = Message::findOrFail($request->message_id);

        if ($message->from_id == Auth::user()->id) {
            $message->delete();
            return response()->json([
                'id' => $request->message_id
            ], 200);
        }
        return;
    }
}

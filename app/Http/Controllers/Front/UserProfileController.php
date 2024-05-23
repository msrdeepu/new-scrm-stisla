<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Notify;

class UserProfileController extends Controller
{

    use FileUploadTrait;

    public function update(Request $request)
    {
        dd($request);

        $request->validate([
            'avatar' => ['nullable', 'image', 'max:500'],
            'name' => ['required', 'string', 'max:50'],
            'user_name' => ['required', 'string', 'max:50', 'unique:users,user_name' . auth()->user()->id],
            'email' => ['required', 'email', 'max:100']
        ]);


        $avatarPath = $this->uploadFile($request, 'avatar');

        $user = Auth::user();
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        if ($avatarPath) $user->avatar = $avatarPath;


        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'min:6', 'confirmed'],
            ]);

            $user->password = bcrypt($request->password);
        }

        $user->save();

        notyf()->addSuccess('Updated Succesfully');

        return response(['message' => 'Updated Succesfully'], 200);
    }
}

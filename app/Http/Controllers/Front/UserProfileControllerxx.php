<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Notify;

class UserProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => ['nullable', 'image', 'max:500'],
            'name' => ['required', 'string', 'max:50'],
            'user_name' => ['required', 'string', 'max:50', 'unique:users,user_name,' . auth()->user()->id],
            'email' => ['required', 'email', 'max:100']
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // Debugging: Log file details
            Log::info('File detected', [
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
            ]);

            $ext = $file->getClientOriginalExtension();
            $fileName = 'media_' . uniqid() . '.' . $ext;

            $destinationPath = public_path('/uploads');

            // Ensure the directory exists
            if (!File::exists($destinationPath)) {
                if (!File::makeDirectory($destinationPath, 0755, true)) {
                    Log::error('Failed to create directory: ' . $destinationPath);
                    return response(['message' => 'Failed to create directory'], 500);
                }
            }

            // Attempt to move the file
            if ($file->move($destinationPath, $fileName)) {
                Log::info('File moved successfully', ['path' => '/uploads/' . $fileName]);
                $avatarPath = '/uploads/' . $fileName;
            } else {
                Log::error('File could not be moved to destination path: ' . $destinationPath);
                return response(['message' => 'File upload failed'], 500);
            }
        } else {
            Log::error('No file found in the request for input name: avatar');
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        if ($avatarPath) {
            $user->avatar = $avatarPath;
        }

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'min:6', 'confirmed'],
            ]);

            $user->password = bcrypt($request->password);
        }

        $user->save();

        notyf()->addSuccess('Updated Successfully');

        return response(['message' => 'Updated Successfully'], 200);
    }
}

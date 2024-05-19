<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class ProfileController extends Controller
{
    public function index()
    {
        return view('superadmin.profile.index');
    }

    public function updateprofile(Request $request)
    {

        // dd($request);

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email'],
        ]);

        $user = Auth::user();

        if (File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $imageName = rand() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('profiles'), $imageName);
            $path = "/profiles/" . $imageName;
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile Updated successfully!');

        return redirect()->back();
    }

    public function updatepassword(Request $request)
    {
        //dd($request);
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);
        toastr()->success('Password Updated successfully!');

        return redirect()->back();
    }
}

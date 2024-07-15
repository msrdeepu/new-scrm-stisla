<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $SocialUser = Socialite::driver($provider)->user();

            // Check if a user with the same email already exists
            $existingUser = User::where('email', $SocialUser->getEmail())->first();
            if ($existingUser) {
                //return redirect('/login')->withErrors(['email' => 'This Email Already Exists']);
                Auth::login($existingUser);
                return redirect('/messenger');
            }

            // Check if a user with the same provider and provider_id already exists
            $user = User::where('provider', $provider)
                ->where('provider_id', $SocialUser->getId())
                ->first();

            //dd($user);



            // If no user exists, create a new one
            if (!$user) {

                $user = User::create([
                    'name' => $SocialUser->getName(),
                    'email' => $SocialUser->getEmail(),
                    'user_name' => $this->generateUserNickName($provider, $SocialUser->getNickname() ?: $SocialUser->getName()),
                    'provider' => $provider,
                    'provider_id' => $SocialUser->getId(),
                    'provider_token' => $SocialUser->token,
                    'email_verified_at' => now()
                ]);
            }

            // Log the user in
            Auth::login($user);
            return redirect('/messenger');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Something went wrong. Please try again later.']);
        }
    }

    private function generateUserNickName($provider, $name)
    {
        $timestamp = now()->format('@YmdHis');
        $nameWithoutSpaces = str_replace(' ', '', $name);
        return $timestamp . '_' . $nameWithoutSpaces;
    }
}


// $user = User::where([
//     'provider' => $provider,
//     'provider_id' => $SocialUser->getId()
// ])->first();
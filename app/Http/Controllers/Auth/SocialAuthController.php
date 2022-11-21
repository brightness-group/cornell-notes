<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirects to appropriate providers based on
     * $provider
     *
     * @param $provider
     * @return RedirectResponse
     */
    public function redirect($provider): RedirectResponse
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->with(['prompt' => 'select_account'])->stateless()->user();

            return $this->handleUser($user, $provider);
        } catch (\Throwable $t) {
            return redirect(route('login'))->with(['status' => 'error', 'message' => ucfirst($provider).' Login failed']);
        }
    }

    public function handleUser($data, $provider)
    {
        $email = $data->getEmail();

        $user = User::where([
            'social->'.$provider.'->id' => $data->id,
        ])->first();

        if (empty($user)) {
            $user = User::where([
                'email' => $email,
            ])->first();
        }

        if (empty($user)) {
            return $this->createUser($data, $provider);
        }

        $social = ($user->social != null) ? $user->social : new \stdClass();
        $social->$provider = ['id' => $data->id, 'token' => $data->token];
        $user->social = $social;
        $user->email_verified_at = ($user->email_verified_at != null) ? $user->email_verified_at : Carbon::now();
        $user->save();

        auth()->login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function createUser($data, $provider)
    {
        try {
            $user = User::create([
                'name' => $data->name,
                'email' => $data->getEmail(),
                'social' => [
                    $provider => [
                        'id' => $data->id,
                        'token' => $data->token,
                    ],
                ],
                'email_verified_at' => Carbon::now(),
            ]);

            return $this->login($user);
        } catch (\Throwable $t) {
            return redirect(route('login'))->with(['status' => 'error', 'message' => 'Login failed. Please try again']);
        }
    }

    public function login($user)
    {
        auth()->login($user);

        return $user()->hasVerifiedEmail() ?
            redirect()->intended(RouteServiceProvider::HOME) : view('auth.verify-email');
    }
}

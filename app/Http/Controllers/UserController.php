<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Utils\Media;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.account.profile', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $response = [
            'success' => true,
            'message' => 'Profile updated.',
            'email_changed' => false,
        ];

        if ($request->hasFile('avatar')) {
            $path = Media::upload($request, 'avatar', $user->dirPath());

            $input['avatar'] = $path;
        } else {
            $input['avatar'] = $user->avatar;
        }

        $user->update($input);

        if ($user->wasChanged('email')) {
            $user->unVerify();
            $user->sendEmailVerificationNotification();

            $response['email_changed'] = true;
        }

        return response($response);
    }

    public function changePassword()
    {
        return view('user.account.change-password');
    }

    public function updatePassword(PasswordRequest $request)
    {
        $user = Auth::user();

        $user->update(['password' => Hash::make($request->password)]);

        return response(['status' => true, 'message' => 'Password changed successfully!!']);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->delete();

        return response(['message' => 'Your account has been deleted successfully.'], 200);
    }

    public function verifyPassword(PasswordRequest $request)
    {
        return response(['message' => 'Password Verified!!.'], 200);
    }
}

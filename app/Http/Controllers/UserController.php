<?php

namespace App\Http\Controllers;

use App\Models\User;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'image_url' => 'required|url',
            'email' => 'required|email',
            'token' => 'required',
        ]);

        $googleId = $request->post('id');
        $name = $request->post('name');
        $imageUrl = $request->post('image_url');
        $email = $request->post('email');
        $token = $request->post('token');

        $client = new Google_Client(['client_id' => '741909550840-d3j8u1aro5dpr9ivlh7mjtt4r5lsfhd2.apps.googleusercontent.com']);
        $payload = $client->verifyIdToken($token);
        if (!$payload)
            return redirect('/')->with('alert', 'success')->with('message', 'Login tidak valid');

        $user = User::where('google_id', '=', $googleId)->first();
        if ($user == null) {
            $user = new User([
                'google_id' => $googleId,
                'name' => $name,
                'email' => $email,
                'image_url' => $imageUrl,
                'token' => $token,
            ]);
        } else {
            $user->google_id = $googleId;
            $user->name = $name;
            $user->email = $email;
            $user->image_url = $imageUrl;
            $user->token = $token;
        }

        $user->save();
        $user->refresh();

        Auth::login($user, true);
        return redirect('/dashboard');
    }

    public function logout()
    {
        $client = new Google_Client([
            'client_id' => '741909550840-d3j8u1aro5dpr9ivlh7mjtt4r5lsfhd2.apps.googleusercontent.com',
            'token' => Auth::user()->token,
        ]);
        $client->revokeToken();
        Auth::logout();
        return redirect('/');
    }
}

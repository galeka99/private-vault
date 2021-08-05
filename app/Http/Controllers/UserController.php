<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

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

        $agent = new Agent();
        $ip = $request->ip();
        $device = $agent->device();
        $platform = $agent->platform() . " " . $agent->version($agent->platform());
        $browser = $agent->browser() . " " . $agent->version($agent->browser());

        if (Log::where('user_id', '=', $user->id)->count() === 20) {
            $first_log = Log::where('user_id', '=', $user->id)->orderBy('id')->first();
            $first_log->delete();
        }
        
        $log = new Log([
            'user_id' => $user->id,
            'ip' => $ip,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
        ]);
        $log->save();

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

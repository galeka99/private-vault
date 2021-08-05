<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $logs = Log::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();

        return view('dashboard.log', ['logs' => $logs]);
    }
}

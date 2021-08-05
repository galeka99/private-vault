<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $accounts = null;
        if ($request->has('q')) {
            $q = $request->get('q', '');
            $accounts = Account::where('owner_id', '=', $user->id)->where('title', 'LIKE', "%$q%")->paginate(25);
        } else {
            $accounts = Account::where('owner_id', '=', $user->id)->paginate(25);
        }
        return view('dashboard.index', ['accounts' => $accounts]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $referer = $request->header('referer');

        $user = Auth::user();
        $title = $request->post('title');
        $username = $request->post('username');
        $password = Crypt::encryptString($request->post('password'));

        $account = new Account([
            'title' => $title,
            'username' => $username,
            'password' => $password,
            'owner_id' => $user->id,
        ]);
        $account->save();

        return redirect($referer)->with('alert', 'success')->with('message', 'Berhasil menambahkan akun');
    }

    public function update(Request $request, int $id)
    {
        $referer = $request->header('referer');
        $user = Auth::user();

        $account = Account::find($id);
        if (!$account)
            return redirect($referer)->with('alert', 'error')->with('message', 'Akun tidak ditemukan');
        if ($account->owner_id !== $user->id)
            return redirect($referer)->with('alert', 'error')->with('message', 'Akun tidak ditemukan');
        
        if ($request->has('title'))
            $account->title = $request->post('title');
        if ($request->has('username'))
            $account->username = $request->post('username');
        if ($request->has('password'))
            $account->password = Crypt::encryptString($request->post('password'));
        $account->save();

        return redirect($referer)->with('alert', 'success')->with('message', 'Berhasil merubah informasi akun');
    }

    public function delete(Request $request, int $id)
    {
        $referer = $request->header('referer');
        $user = Auth::user();

        $account = Account::find($id);
        if (!$account)
            return redirect($referer)->with('alert', 'error')->with('message', 'Akun tidak ditemukan');
        if ($account->owner_id !== $user->id)
            return redirect($referer)->with('alert', 'error')->with('message', 'Akun tidak ditemukan');
            
        $account->delete();
        return redirect($referer)->with('alert', 'success')->with('message', 'Berhasil menghapus akun');
    }
}

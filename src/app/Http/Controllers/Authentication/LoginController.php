<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm($auth_url): View
    {
        User::where('auth_url', $auth_url)->firstOrFail();
        return view('authentication.login');
    }

    public function doLogin(LoginRequest $request, $auth_url): RedirectResponse
    {
        try {
            if (Auth::attempt($request->only(['email', 'password'], $request->remember))) {
                $request->session()->regenerate();
                if (auth()->user()->status == 'pending' && auth()->user()->hasVerifiedEmail()) {
                    auth()->logout();
                    $request->session()->invalidate();
                    return back()->withErrors(['active' => 'Your email is verified but your account is awaiting activation by an administrator']);
                }
                if (\auth()->user()->type != 'admin') {
                    $decryptAuthUrl = decrypt($auth_url);
                    $decryptAuthUrlId = explode('_', $decryptAuthUrl)[0];
                    if ($decryptAuthUrlId != auth()->id()) {
                        auth()->logout();
                        $request->session()->invalidate();
                        return back()->withErrors(['error' => 'The provided credentials do not match our records, please make sure of your credentials']);
                    }
                }
                return redirect()->route('home');
            }
            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ])->onlyInput('error');
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        $auth_url = auth()->user()->auth_url;
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->route('client.show_login_form', $auth_url);
    }
}

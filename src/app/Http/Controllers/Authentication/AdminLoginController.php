<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('authentication.admin_login');
    }

    public function doLogin(AdminLoginRequest $request): RedirectResponse
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
                    auth()->logout();
                    $request->session()->invalidate();
                    return back()->withErrors(['error' => 'The provided credentials do not match our records, please make sure of your credentials']);
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
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.show_login_form');
    }
}

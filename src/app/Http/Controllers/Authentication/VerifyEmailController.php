<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('client.show_login_form' . '?verified=1', $request->user()->auth_url);
        }

        if ($request->user()->markEmailAsVerified()) {
            $request->user()->status = 'pending';
            $request->user()->save();
            event(new Verified($request->user()));

            Auth::logout();

            return redirect()
                ->route('client.show_login_form', $request->user()->auth_url)
                ->withErrors(['active' => 'Your email is verified but your account is awaiting activation by an administrator']);
        }
        if ($request->user()->referral_id) {
            $user = $request->user();
            $user->status = 'pending';
            $token = bcrypt(Str::random(60));
            $user->remember_token = $token;
            $user->save();
            return redirect()->route('password.set', ['token' => $token, 'email' => $user->email]);
        }
        return redirect()->route('client.show_login_form' . '?verified=1', $request->user()->auth_url);
    }
}

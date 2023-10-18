<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->route('client.show_login_form', $request->user()->auth_url)
            : view('authentication.verify-email');
    }
}

<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('client.show_login_form', $request->user()->auth_url);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', __('app.verification_link_sent'));
    }
}

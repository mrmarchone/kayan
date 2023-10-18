<?php

namespace App\Http\Controllers\Authentication;

use App\Events\AdminActivateUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\SetNewPasswordRequest;
use App\Models\Country;
use App\Models\DemoRequest;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('authentication.reset_password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', \Illuminate\Validation\Rules\Password::min(10)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised(), 'confirmed'],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. otherwise we will parse the error and return the response.
        $currentUser = User::where('email', $request->email)->firstOrFail();
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                    'password_changed_at' => Carbon::now()
                ])->save();

                event(new PasswordReset($user));
            }
        );
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('client.show_login_form', $currentUser->auth_url)->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    public function setNewPasswordForm($token, $email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $countries = Country::query()->pluck('id', 'name');
        $sections = Section::query()->pluck('id', 'name');
        if ($user->remember_token != $token) {
            abort(403);
        }
        return view('authentication.set_password', ['token' => $token, 'email' => $email, 'countries' => $countries, 'sections' => $sections]);
    }

    public function setPassword(SetNewPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $demoUserExists = DemoRequest::where('email', $user->email)->where('is_verified', true)->first();
            $user->password = Hash::make($request->password);
            $user->status = 'pending';
            $user->remember_token = null;
            $user->country_id = $request->country;
            $user->section_id = $request->section_id;
            $user->email_verified_at = now();
            $user->password_changed_at = now();
            if ($demoUserExists) {
                $user->company = $demoUserExists->company;
                $user->status = 'active';
            }
            $user->save();
            if ($user->status == 'active') {
                AdminActivateUserEvent::dispatch($user);
            }
            Auth::logout();
            DB::commit();
            return redirect()
                ->route('client.show_login_form', $user->auth_url)
                ->withErrors(['active' => $user->status == 'active' ? 'Congratulations! your account has been activated.' : 'Your email is verified but your account is awaiting activation by an administrator']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error')->withInput(\request()->all());
        }
    }
}

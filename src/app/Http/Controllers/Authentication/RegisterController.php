<?php

namespace App\Http\Controllers\Authentication;

use App\Events\NewUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegisterForm(): View
    {
        $countries = Country::query()->pluck('id', 'name');
        return view('authentication.register', compact('countries'));
    }

    public function doRegister(RegisterRequest $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company' => $request->company,
                'phone' => $request->phone,
                'country_id' => $request->country,
                'role' => 'owner',
                'type' => 'client'
            ]);
            $user->assignRole('owner');
            Auth::login($user);
            event(new NewUserEvent($user, 'new'));
            DB::commit();
            return redirect()->route('frontend.home');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }
}

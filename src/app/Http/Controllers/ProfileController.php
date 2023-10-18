<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->password == $request->old_password) {
                return back()->withErrors([
                    'password' => 'The new password same as old password. Please change it to another password',
                ])->onlyInput('error');
            }
            auth()->user()->update([
                'password' => bcrypt($request->password),
                'password_changed_at' => now()
            ]);
            DB::commit();
            return redirect()->route('home')->with(['success' => 'Updated Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }


}

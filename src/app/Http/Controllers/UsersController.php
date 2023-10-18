<?php

namespace App\Http\Controllers;

use App\Events\AdminActivateUserEvent;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Country;
use App\Models\Section;
use App\Models\User;
use App\Notifications\InvitedUserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users')->only(['index', 'show', 'data']);
        $this->middleware('permission:update users')->only(['edit', 'update']);
        $this->middleware('permission:create users')->only(['create', 'store']);
        $this->middleware('permission:delete users')->only(['delete']);
        $this->middleware('permission:activate users')->only(['activate']);
        $this->middleware('permission:deactivate users')->only(['deactivate']);
        $this->middleware('permission:createToken users')->only(['createToken']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        $users = $this->getUserModel()->with(['country', 'section']);
        return DataTables::eloquent($users)
            ->addColumn('role', function ($user) {
                return $user->roles()->first()?->name ?? '--';
            })
            ->addColumn('industry', function ($user) {
                return $user->section?->name ?? '--';
            })
            ->addColumn('country', function ($user) {
                return $user->country?->name ?? '--';
            })
            ->addColumn('activate', function ($user) {
                $url = route('user.activate', $user->hashId);
                $data = '<form action="' . $url . '" method="POST">';
                $data .= csrf_field();
                $data .= method_field('PATCH');
                if ($user->status == 'active') {
                    $data .= '<input type="submit" disabled class="btn btn-primary" value="Activate">';
                } else {
                    $data .= '<input type="submit" class="btn btn-primary" value="Activate">';
                }

                $data .= '</form>';
                return $data;
            })
            ->addColumn('deactivate', function ($user) {
                $url = route('user.deactivate', $user->hashId);
                $data = '<form action="' . $url . '" method="POST">';
                $data .= csrf_field();
                $data .= method_field('PATCH');
                if ($user->status == 'active') {
                    $data .= '<input type="submit" class="btn btn-primary" value="De Activate">';
                } else {
                    $data .= '<input type="submit" disabled class="btn btn-primary" value="De Activate">';
                }

                $data .= '</form>';
                return $data;
            })
            ->addColumn('create_token', function ($user) {
                $url = route('user.create_token', $user->hashId);
                $data = '<form action="' . $url . '" method="POST">';
                $data .= csrf_field();
                $data .= method_field('PATCH');
                if ($user->status == 'active') {
                    $data .= '<input type="submit" class="btn btn-primary" value="Create Token">';
                } else {
                    $data .= '<input type="submit" disabled class="btn btn-primary" value="Create Token">';
                }

                $data .= '</form>';
                return $data;
            })
            ->addColumn('options', function ($user) {
                return view('layouts.components.table_options', ['model' => $user,
                    'modelName' => 'users'])->render();
            })
            ->orderColumns(['section_id', 'country_id'], '-:column $1')
            ->rawColumns(['activate', 'deactivate', 'create_token', 'options'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::query()->pluck('id', 'name');
        $countries = Country::query()->pluck('id', 'name');
        if (auth()->user()->type == 'client' || auth()->user()->type == 'demo') {
            $roles = Role::query()->where('created_by', auth()->user()->id)->where('type', auth()->user()->type)->pluck('id', 'name');
        } else {
            $roles = Role::query()->pluck('id', 'name');
        }
        return view('users.create', compact('countries', 'sections', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'section_id' => $request->section_id,
                'type' => auth()->user()->type == 'admin' ? $request->type : auth()->user()->type
            ]);
            $user->settings()->create([
                'results_count' => auth()->user()->type == 'admin' ? ($request->results_count ?? 0) : 0,
                'domains_limit' => auth()->user()->type == 'admin' ? ($request->domains_limit ?? 0) : 0,
                'breaches_limit' => auth()->user()->type == 'admin' ? ($request->breaches_limit ?? 0) : 0,
                'show_scan_results_password' => auth()->user()->type == 'admin' ? ($request->show_password == 'on') : false
            ]);
            $user->assignRole($request->role_id);
            $admins = User::where('type', 'admin')->get();
            Notification::send($admins, new InvitedUserNotification(auth()->user(), $user));
            DB::commit();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error')->withInput(\request()->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->getUserModel()->findOrFailByHashId($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sections = Section::query()->pluck('id', 'name');
        $countries = Country::query()->pluck('id', 'name');
        if (auth()->user()->type == 'client' || auth()->user()->type == 'demo') {
            $roles = Role::query()->where('created_by', auth()->user()->id)->where('type', auth()->user()->type)->pluck('id', 'name');
        } else {
            $roles = Role::query()->pluck('id', 'name');
        }
        $user = $this->getUserModel()->findOrFailByHashId($id);
        return view('users.edit', compact('user', 'countries', 'roles', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        $user = $this->getUserModel()->findOrFailByHashId($id);
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'section_id' => $request->section_id,
                'type' => auth()->user()->type == 'admin' ? $request->type : auth()->user()->type,
            ]);
            $user->settings->update([
                'results_count' => auth()->user()->type == 'admin' ? ($request->results_count ?? 0) : 0,
                'domains_limit' => auth()->user()->type == 'admin' ? ($request->domains_limit ?? 0) : 0,
                'breaches_limit' => auth()->user()->type == 'admin' ? ($request->breaches_limit ?? 0) : 0,
                'show_scan_results_password' => auth()->user()->type == 'admin' ? ($request->show_password == 'on') : false
            ]);
            $user->syncRoles([$request->role_id]);
            DB::commit();
            return redirect()->back()->with(['success' => 'Updated Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error')->withInput(\request()->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        $user = $this->getUserModel()->findOrFailByHashId($id);
        try {
            $user->delete();
            DB::commit();
            return redirect()->back()->with(['success' => 'Deleted Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error')->withInput(\request()->all());
        }
    }

    public function createToken(string $id): RedirectResponse
    {
        $user = $this->getUserModel()->findOrFailByHashId($id);
        DB::beginTransaction();
        try {
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->update([
                'api_token' => $token
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => 'Token Created Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    public function activate(string $id): RedirectResponse
    {
        $user = $this->getUserModel()->findOrFailByHashId($id);
        DB::beginTransaction();
        try {
            if ($user->status == 'active') {
                return redirect()->back()->with(['success' => 'User is already active']);
            }
            $user->update([
                'status' => 'active'
            ]);
            AdminActivateUserEvent::dispatch($user);
            DB::commit();
            return redirect()->back()->with(['success' => 'User Activated Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    public function deactivate(string $id): RedirectResponse
    {
        $user = $this->getUserModel()->findOrFailByHashId($id);
        DB::beginTransaction();
        try {
            if ($user->status == 'inactive') {
                return redirect()->back()->with(['success' => 'User is already inactive']);
            }
            $user->update([
                'status' => 'inactive'
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => 'User Deactivated Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    private function getUserModel()
    {
        $user = User::query();
        if (auth()->user()->type == 'client' || auth()->user()->type == 'demo') {
            $user->where(function ($query) {
                $query->where('referral_id', auth()->user()->id)->orWhere('id', auth()->user()->id);
            });
        }
        return $user;
    }
}

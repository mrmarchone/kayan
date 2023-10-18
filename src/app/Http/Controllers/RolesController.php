<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Permission;
use App\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view roles')->only(['index', 'show', 'data']);
        $this->middleware('permission:update roles')->only(['edit', 'update']);
        $this->middleware('permission:create roles')->only(['create', 'store']);
        $this->middleware('permission:delete roles')->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('roles.index');
    }

    public function data()
    {
        $data = $this->getRoleModel();
        return DataTables::of($data)
            ->addColumn('options', function ($item) {
                return view('layouts.components.table_options', [
                    'model' => $item,
                    'modelName' => 'roles'
                ])->render();
            })
            ->rawColumns(['options'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::query()->get()->groupBy('group');
        if (auth()->user()->type == 'client' || auth()->user()->type == 'demo') {
            $permissions = auth()->user()->roles->first()->permissions->groupBy('group');
        }

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'type' => auth()->user()->type == 'admin' ? $request->type : auth()->user()->type,
                'created_by' => auth()->user()->id
            ]);
            $role->syncPermissions($request->permissions);
            DB::commit();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    public function show(string $id): View
    {
        $role = $this->getRoleModel()->with(['permissions', 'users'])->findOrFailByHashId($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $role = $this->getRoleModel()->with('permissions')->findOrFailByHashId($id);
        $permissions = Permission::query()->get()->groupBy('group');
        if (auth()->user()->type == 'client' || auth()->user()->type == 'demo') {
            $permissions = auth()->user()->roles->first()->permissions->groupBy('group');
        }
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id): RedirectResponse
    {
        $role = $this->getRoleModel()->findOrFailByHashId($id);
        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
                'guard_name' => 'web',
                'type' => auth()->user()->type == 'admin' ? $request->type : auth()->user()->type,
                'created_by' => auth()->user()->id
            ]);
            $role->syncPermissions($request->permissions);
            DB::commit();
            return redirect()->back()->with(['success' => 'Edited Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $role = $this->getRoleModel()->findOrFailByHashId($id);
            if ($role->users->count() > 0) {
                return back()->withErrors([
                    'error' => 'You can not delete this role because there are ' . $role->users->count() . ' Users Related to it.',
                ])->onlyInput('error')->withInput(\request()->all());
            }
            $role->delete();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    private function getRoleModel()
    {
        return Role::query()->when(auth()->user()->type == 'client' || auth()->user()->type == 'demo', function ($query) {
            return $query->where('created_by', auth()->user()->id)->where('type', auth()->user()->type);
        });
    }
}

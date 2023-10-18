<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permissions')->only(['index', 'show', 'data']);
        $this->middleware('permission:update permissions')->only(['edit', 'update']);
        $this->middleware('permission:create permissions')->only(['create', 'store']);
        $this->middleware('permission:delete permissions')->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('permissions.index');
    }

    public function data()
    {
        $data = Permission::query();
        return DataTables::of($data)
            ->addColumn('options', function ($item) {
                return view('layouts.components.table_options', [
                    'model' => $item,
                    'modelName' => 'permissions'
                ])->render();
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Permission::create($request->only('name', 'group', 'guard_name'));
            DB::commit();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::query()->with(['roles', 'users'])->findOrFailByHashId($id);
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFailByHashId($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, string $id)
    {
        $permission = Permission::findOrFailByHashId($id);
        DB::beginTransaction();
        try {
            $permission->update($request->only('name', 'group', 'guard_name'));
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
    public function destroy(string $id)
    {
        try {
            $permission = Permission::findOrFailByHashId($id);
            if ($permission->roles->count() > 0) {
                return back()->withErrors([
                    'error' => 'You can not delete this permission because there are ' . $permission->roles->count() . ' Roles Related to it.',
                ])->onlyInput('error')->withInput(\request()->all());
            }
            $permission->delete();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error');
        }
    }
}

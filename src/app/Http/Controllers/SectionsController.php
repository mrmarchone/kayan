<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionCreateRequest;
use App\Http\Requests\SectionUpdateRequest;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view sections')->only(['index', 'show', 'data']);
        $this->middleware('permission:update sections')->only(['edit', 'update']);
        $this->middleware('permission:create sections')->only(['create', 'store']);
        $this->middleware('permission:delete sections')->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sections.index');
    }

    public function data()
    {
        $data = Section::query();
        return DataTables::of($data)
            ->addColumn('options', function ($item) {
                return view('layouts.components.table_options', [
                    'model' => $item,
                    'modelName' => 'sections'
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
        return view('sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Section::create([
                'name' => $request->name
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => 'Added Successfully']);
        } catch (\Exception $exception) {
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
        $section = Section::findOrFailByHashId($id);
        return view('sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $section = Section::findOrFailByHashId($id);
        return view('sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        $section = Section::findOrFailByHashId($id);
        try {
            $section->update([
                'name' => $request->name
            ]);
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
        $section = Section::findOrFailByHashId($id);
        try {
            if ($section->users->count() > 0) {
                return back()->withErrors([
                    'error' => 'You can not delete this section because there are ' . $section->users->count() . ' users related to it.',
                ])->onlyInput('error')->withInput(\request()->all());
            }
            $section->delete();
            DB::commit();
            return redirect()->back()->with(['success' => 'Deleted Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'There is an error.',
            ])->onlyInput('error')->withInput(\request()->all());
        }
    }
}

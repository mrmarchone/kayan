<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view categories')->only(['index', 'show', 'data']);
        $this->middleware('permission:update categories')->only(['edit', 'update']);
        $this->middleware('permission:create categories')->only(['create', 'store']);
        $this->middleware('permission:delete categories')->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    public function data()
    {
        $categories = Category::query();
        return DataTables::of($categories)
            ->addColumn('options', function ($category) {
                return view('layouts.components.table_options', ['model' => $category,
                    'modelName' => 'categories'])->render();
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
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
        $category = Category::findOrFailByHashId($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFailByHashId($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        $category = Category::findOrFailByHashId($id);
        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
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
        $category = Category::findOrFailByHashId($id);
        try {
            if ($category->posts->count() > 0) {
                return back()->withErrors([
                    'error' => 'You can not delete this category because there are ' . $category->posts->count() . ' Blogs Related to it.',
                ])->onlyInput('error')->withInput(\request()->all());
            }
            $category->delete();
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

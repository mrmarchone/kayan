<?php

namespace Mrmarchone\Kayan\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCreateRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Post::query()->paginate(10);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kayan::pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $file = $request->file('image');
            $image_name = time() . '_' . $file->getClientOriginalName();
            $path = storage_path('app/public/posts') . "/" . $image_name;
            Image::make($file->getRealPath())->resize(1200, 830)->save($path);
            $blog = Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $image_name,
                'content' => $request->input('content'),
                'category_id' => $request->category_id,
                'user_id' => auth()->user()->id,
                'type' => $request->type
            ]);
            Event::dispatch(new SendBlogToUsersEvent($blog));
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
        $blog = Post::findOrFailByHashId($id);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Post::findOrFailByHashId($id);
        $categories = Category::query()->pluck('id', 'name')->toArray();
        return view('blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        $post = Post::findOrFailByHashId($id);
        try {
            $image = [];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $image_name = time() . '_' . $file->getClientOriginalName();
                $path = storage_path('app/public/posts') . "/" . $image_name;
                Image::make($file->getRealPath())->resize(1200, 830)->save($path);
                $image['image'] = $image_name;
                if (Storage::exists('public/posts' . "/" . $post->image)) {
                    Storage::delete('public/posts' . "/" . $post->image);
                }
            }
            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->input('content'),
                'category_id' => $request->category_id,
                'user_id' => auth()->user()->id,
                'type' => $request->type,
                ...$image
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
        $post = Post::findOrFailByHashId($id);
        try {
            $post->delete();
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

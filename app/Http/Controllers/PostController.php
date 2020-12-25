<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    /**
     * Referensi: <https://laravel.com/docs/5.8/collections>
     * Referensi: <https://laravel.com/docs/5.8/filesystem>
     */

    private $filename = 'posts.json';

    private $posts;

    function __construct()
    {
        if (!Storage::exists($this->filename)) Storage::put($this->filename, '[]');
        $this->load();
    }

    private function load()
    {
        return $this->posts = $this->posts
            ?: collect(json_decode(Storage::get($this->filename), true));
    }

    protected function save()
    {
        Storage::put($this->filename, $this->prepareSave());
        return $this;
    }

    protected function prepareSave()
    {
        if (is_array($this->posts)) {
            return json_encode($this->posts);
        }

        if ($this->posts instanceof Collection) {
            return json_encode($this->posts->toArray());
        }

        return '[]';
    }

    private function reload()
    {
        $this->posts = null;
        $this->posts = $this->load();

        return $this;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content_title = 'All Posts';
        $posts = $this->posts->sortByDesc('created_at');

        if ($request->has('q')) {
            $posts = $this->posts->filter(function ($item) use ($request) {
                return false !== stristr($item['title'], $request->q);
            });
            $content_title = 'Search result of ' . Str::limit($request->q, 100);
        }

        return view('posts.index', compact('posts', 'content_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'author' => 'required|string|max:50',
            'author_photo' => 'required|mimes:jpg,png,jpeg|max:1000',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:300',
            'image' => 'required|mimes:jpg,png,jpeg|max:1000',
            'content' => 'required'
        ]);

        $id = ($this->posts->last()['id'] ?? 0) + 1;

        $validated['id'] = $id;
        $validated['slug'] = Str::slug($request->title) . '-' . $id;
        $validated['author_photo'] = $request->file('author_photo')->store('images/authors', 'public');
        $validated['image'] = $request->file('image')->store('images/posts', 'public');
        $validated['created_at'] = now()->toDateTimeString();
        $validated['updated_at'] = now()->toDateTimeString();

        $this->posts->push($validated);

        $this->save()->reload();
        return back()->with('success', 'Successfully create new article');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->posts->where('slug', $slug)->first() ?? null;
        abort_if(is_null($post), 404);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = $this->posts->where('slug', $slug)->first() ?? null;
        abort_if(is_null($post), 404, 'Article Not Found');
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $key = $this->posts->search(function ($item) use ($slug) {
            return $item['slug'] === $slug;
        });
        abort_if($key === false, 404, 'Article Not Found');
        $post = $this->posts->get($key);

        $validated = $this->validate($request, [
            'author' => 'required|string|max:50',
            'author_photo' => 'nullable|mimes:jpg,png,jpeg|max:1000',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:300',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:1000',
            'content' => 'required'
        ]);

        $validated['author_photo'] = $post['author_photo'];
        $validated['image'] = $post['image'];
        $validated['slug'] = Str::slug($request->title) . '-' . $post['id'];
        $validated['updated_at'] = now()->toDateTimeString();

        if ($request->hasFile('author_photo')) {
            $validated['author_photo'] = $request->file('author_photo')->store('images/authors', 'public');
            Storage::delete($this->posts['author_photo']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/posts', 'public');
            Storage::delete($this->posts['image']);
        }

        $post = array_replace($post, $validated);

        $this->posts = $this->posts->replace([$key => $post]);
        $this->save()->reload();
        return redirect()->route('post.edit', $post['slug'])->with('success', 'Article Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $key = $this->posts->search(function ($item) use ($slug) {
            return $item['slug'] === $slug;
        });

        abort_if($key === false, 404, 'Article Not Found');

        Storage::delete($this->posts[$key]['image']);
        $this->posts->forget($key);
        $this->save()->reload();
        return redirect()->route('post.index')->with('success', 'Article Deleted');
    }
}

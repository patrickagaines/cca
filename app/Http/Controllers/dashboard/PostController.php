<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function __construct(private Post $post)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post->with(['images' => function (Builder $query) {
            $query->select(['id', 'post_id', 'file_path'])
                  ->orderBy('position')
                  ->first();
        }])->select(['id', 'title'])->paginate(15);

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->post
            ->with('images')
            ->findOrFail($id);

        return view('dashboard.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

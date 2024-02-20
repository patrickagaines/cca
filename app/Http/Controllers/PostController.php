<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $posts = $this->post
            ->orderBy('created_at', 'desc')
            ->with('images',
                function (HasMany $query) {
                    $query->where('display_order', '=', 0)
                          ->get();
                })
            ->get();

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

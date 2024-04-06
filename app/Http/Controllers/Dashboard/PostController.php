<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StorePostRequest;
use App\Http\Requests\Dashboard\UpdatePostRequest;
use App\Services\PostService;
use Exception;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    )
    {
    }

    public function index()
    {
        $posts = $this->postService->all();

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->postService->create($request);

        } catch (Exception $e) {
            return redirect(status: $e->getCode())
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return view('dashboard.posts.show', ['post' => $post]);
    }

    public function show(string $id)
    {
        $post = $this->postService->find($id);

        return view('dashboard.posts.show', ['post' => $post]);
    }

    public function edit(string $id)
    {
        $post = $this->postService->find($id);

        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function update(UpdatePostRequest $request, string $id)
    {
        try {
            $post = $this->postService->update($request, $id);

        } catch (Exception $e) {
            return redirect(status: $e->getCode())
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('dashboard.posts.show', ['post' => $post])
            ->with('success', 'Post successfully updated');
    }

    public function destroy(string $id)
    {
        try {
            $this->postService->delete($id);
        } catch (Exception $e) {
            return redirect(status: $e->getCode())
                ->back()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post successfully deleted.');
    }
}

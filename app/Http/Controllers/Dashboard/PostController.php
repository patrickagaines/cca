<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PostRequest;
use App\Jobs\OptimizeImage;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function __construct(
        private readonly Post  $post,
        private readonly Image $image
    )
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
        }])->select(['id', 'title'])->orderBy('created_at', 'desc')->paginate(15);

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
    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $post = $this->post->create(['title' => $validated['title']]);

        foreach ($validated['images'] as $image) {

            $imageFile = $validated['image_files'][$image['file_index']];

            if ($filePath = $imageFile->storePublicly('images', ['disk' => 'public'])) {
                $imageModel = $this->image->create([
                    'post_id'   => $post->id,
                    'file_name' => basename($filePath),
                    'file_path' => "storage/$filePath",
                    'caption'   => $image['caption'],
                    'position'  => $image['position']
                ]);

                OptimizeImage::dispatch($imageModel);

            }
        }

        return view('dashboard.posts.show', ['post' => $post]);
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
        $post = $this->post
            ->with('images')
            ->findOrFail($id);

        return view('dashboard.posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        dd($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
    }
}

<?php

namespace App\Services;

use App\Exceptions\FailedToCreatePostException;
use App\Jobs\OptimizeImage;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use League\Flysystem\UnableToWriteFile;
use Throwable;

class PostService
{
    public function __construct(
        private readonly Post  $post,
        private readonly Image $image
    )
    {
    }

    public function get(string $id): Post
    {
        return $this->post
            ->with('images')
            ->findOrFail($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->post
            ->with(['images' => function (Builder $query) {
                $query->select(['id', 'post_id', 'file_path'])
                      ->orderBy('position')
                      ->first();
            }])
            ->select(['id', 'title'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }


    /**
     * @throws FailedToCreatePostException
     */
    public function create($storePostData): Post
    {
        try {
            DB::beginTransaction();

            $post = $this->post->create(['title' => $storePostData['title']]);

            foreach ($storePostData['images'] as $image) {

                $imageFile = $storePostData['image_files'][$image['file_index']];
                $filePath  = $imageFile->storePublicly('images', ['disk' => 'public']);

                if (!$filePath) {
                    // handle exception
                }

                $imageModel = $this->image->create([
                    'post_id'   => $post->id,
                    'file_name' => basename($filePath),
                    'file_path' => "storage/$filePath",
                    'caption'   => $image['caption'],
                    'position'  => $image['position']
                ]);

                OptimizeImage::dispatch($imageModel)->afterCommit();
            }

            DB::commit();
        } catch (Throwable|UnableToWriteFile $e) {
            DB::rollBack();
            report($e);
            throw new FailedToCreatePostException();
        }

        return $post;
    }
}

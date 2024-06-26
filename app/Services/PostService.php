<?php

namespace App\Services;

use App\Exceptions\FailedToCreatePostException;
use App\Exceptions\FailedToDeletePostException;
use App\Exceptions\FailedToUpdatePostException;
use App\Http\Requests\Dashboard\StorePostRequest;
use App\Http\Requests\Dashboard\UpdatePostRequest;
use App\Jobs\DeletePublicFiles;
use App\Jobs\OptimizeImage;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostService
{
    public function __construct(
        private readonly Post  $post,
        private readonly Image $image
    )
    {
    }

    public function all(): LengthAwarePaginator
    {
        return $this->post
            ->with(['images' => function (Builder $query) {
                $query->where('position', 1)
                      ->select(['id', 'post_id', 'file_path', 'thumbnail_path']);
            }])
            ->select(['id', 'title'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function find(string $id): Post
    {
        return $this->post
            ->with(['images' => function (Builder $query) {
                $query->orderBy('position');
            }])
            ->findOrFail($id);
    }

    /**
     * @throws FailedToCreatePostException
     */
    public function create(StorePostRequest $request): Post
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $post = $this->post->create(['title' => $validated['title']]);

            foreach ($validated['images'] as $image) {

                $imageFile = $validated['image_files'][$image['file_index']];

                $imageModel = $this->createImage($post->id, $imageFile, $image['caption'], $image['position']);

                OptimizeImage::dispatch($imageModel)->afterCommit();
            }

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            throw new FailedToCreatePostException();
        }

        return $post;
    }

    /**
     * @throws FailedToUpdatePostException
     */
    public function update(UpdatePostRequest $request, string $postId): Post
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $post        = $this->post->find($postId);
            $post->title = $validated['title'];
            $post->save();

            foreach ($validated['images'] as $image) {
                if (isset($image['file_index'])) {
                    $imageFile = $validated['image_files'][$image['file_index']];

                    $imageModel = $this->createImage($postId, $imageFile, $image['caption'], $image['position']);

                    OptimizeImage::dispatch($imageModel)->afterCommit();
                } elseif (isset($image['id'])) {
                    $this->updateImage($image['id'], $image['caption'], $image['position']);
                }
            }

            if (isset($validated['deleted_images'])) {
                foreach ($validated['deleted_images'] as $imageId) {
                    $imageFiles = $this->deleteImage($imageId);

                    DeletePublicFiles::dispatch('images', $imageFiles)->afterCommit();
                }
            }

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            throw new FailedToUpdatePostException();
        }

        return $post;
    }

    /**
     * @throws FailedToDeletePostException
     */
    public function delete(string $id): void
    {
        try {
            DB::beginTransaction();

            $postImages = $this->image
                ->where('post_id', $id)
                ->select(['file_path', 'thumbnail_path'])
                ->get();

            $imageFiles = [];

            foreach ($postImages as $image) {
                $imageFiles[] = basename($image->file_path);
                $imageFiles[] = basename($image->thumbnail_path);
            }

            DeletePublicFiles::dispatch('images', $imageFiles)->afterCommit();

            $this->post->where('id', $id)->delete();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            throw new FailedToDeletePostException();
        }
    }

    private function createImage(string $postId, UploadedFile $imageFile, string|null $caption, int $position): Image
    {
        $filePath = $imageFile->storePublicly('images', ['disk' => 'public']);

        return $this->image->create([
            'post_id'   => $postId,
            'file_name' => basename($filePath),
            'file_path' => "storage/$filePath",
            'caption'   => $caption,
            'position'  => $position
        ]);
    }

    private function updateImage(int $imageId, string|null $caption, int $position): void
    {
        $this->image->where('id', $imageId)
                    ->update([
                        'caption'  => $caption,
                        'position' => $position
                    ]);
    }

    /**
     * Returns an array of the associated files to be removed from disk
     */
    private function deleteImage(int $imageId): array
    {
        $image = $this->image->find($imageId);

        $imageFiles = [
            basename($image->file_path),
            basename($image->thumbnail_path)
        ];

        $image->delete();

        return $imageFiles;
    }
}

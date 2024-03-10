<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class OptimizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Image $image)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imageFileName = $this->image->original_file_name;
        $imagePath = storage_path("app/public/images/$imageFileName");

        $interventionImage = InterventionImage::read($imagePath);
        $size = $interventionImage->size();

        if ($size->isLandscape()) {
            $interventionImage->scaleDown(height: 1600);
            $interventionImage->save();

            $croppedImage = $interventionImage->resizeCanvas(
                width: $interventionImage->height(),
                height: $interventionImage->height()
            );

            $croppedImageFileName = "$imageFileName-1x1";

            $croppedImage->save(storage_path("app/public/images/$croppedImageFileName"));

            $this->image->file_path = "storage/images/$croppedImageFileName";
            $this->image->save();
        }
    }
}

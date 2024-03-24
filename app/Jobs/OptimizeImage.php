<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class OptimizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Image $image)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imagesDirectory = storage_path('app/public/images');
        $fileName        = $this->image->file_name;
        $filePath        = "$imagesDirectory/$fileName";

        $interventionImage = InterventionImage::read($filePath);
        $size              = $interventionImage->size();

        if ($size->isPortrait()) {
            $interventionImage->scaleDown(height: 1920);
            $interventionImage->save();

            $interventionImage->scaleDown(width: 600);
            $interventionImage->resizeCanvas($interventionImage->width(), $interventionImage->width());
        } else {
            $interventionImage->scaleDown(width: 1920);
            $interventionImage->save();

            $interventionImage->scaleDown(height: 600);
            $interventionImage->resizeCanvas($interventionImage->height(), $interventionImage->height());
        }

        $thumbnailFileName = substr_replace($fileName, '-600x600', strpos($fileName, '.'), 0);
        $interventionImage->save("$imagesDirectory/$thumbnailFileName");

        $this->image->thumbnail_path = "storage/images/$thumbnailFileName";
        $this->image->save();
    }
}

<?php

namespace App\Jobs;

use App\Models\Image as ModelsImage;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $params)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imageClass = Image::make($this->params['path'])->resize($this->params['width'], $this->params['heigth']);
        $imageClass->save(explode(".", $this->params['path'])[0] . "-{$this->params['num']}.webp");
    }
}

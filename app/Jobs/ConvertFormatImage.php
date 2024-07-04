<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Intervention\Image\Facades\Image;


class ConvertFormatImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $caminhoWebp = explode(".", $this->params['path'])[0] . ".webp";
        $imageClass = Image::make($this->params['path']);
        $imageClass->encode("webp");
        $imageClass->save($caminhoWebp);

        Bus::batch([
            ResizeImage::dispatch([
                "path" => $caminhoWebp,
                "width" => 1280,
                "heigth" => 720,
                "num" => 3,
            ]),
            ResizeImage::dispatch([
                "path" => $caminhoWebp,
                "width" => 640,
                "heigth" => 480,
                "num" => 2,
            ]),
            ResizeImage::dispatch([
                "path" => $caminhoWebp,
                "width" => 480,
                "heigth" => 360,
                "num" => 1,
            ]),
        ])->dispatch();
    }
}

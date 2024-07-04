<?php

namespace Database\Seeders;

use App\Jobs\ConvertFormatImage;
use App\Jobs\ResizeImage;
use App\Models\Image;
use Intervention\Image\Facades\Image as ImageClass;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start = microtime(true);
        DB::beginTransaction();
        $total = fn () => microtime(true) - $start;
        $imagens = [
            "51122.jpg",
            "51291.jpg",
            "R.jpg",
            "51181.jpg",
        ];

        $posts = Post::factory(10)->create();
        $posts->each(function ($post) use ($imagens, $total) {
            $imageName = $imagens[rand(0, 3)];
            $arquivoImagem = new UploadedFile(
                path: public_path("/img/$imageName"),
                originalName: $imageName,
                mimeType: "image/jpg"
            );
            $arquivoImagem->storeAs("public/images", name: $arquivoImagem->hashName());

            $image = Image::create([
                'nome'          => $arquivoImagem->hashName(),
                'original_nome' => $arquivoImagem->hashName(),
                'path'          => "images/{$arquivoImagem->hashName()}",
                'mime_type'     => $arquivoImagem->getMimeType(),
                'size'          => $arquivoImagem->getSize()
            ]);

            $post->imagem_id = $image->id;
            $post->user_id = 1;
            $post->save();
            //inicia resize
            ConvertFormatImage::dispatch(["path" => storage_path("app/public/{$image->path}")]);

            DB::commit();
        });

        dd($total());
    }
}

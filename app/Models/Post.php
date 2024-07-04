<?php

namespace App\Models;

use App\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'imagem_id',
        'user_id',
        "status",
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
        ];
    }

    public function image(): HasOne
    {
        return $this->hasOne(Image::class, "id", "imagem_id");
    }
}

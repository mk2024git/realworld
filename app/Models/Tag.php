<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public static function popularTags($limit = 8)
    {
        return self::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}

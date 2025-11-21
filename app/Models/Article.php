<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Field yang bisa diisi (mass assignment)
     */
    protected $fillable = [
        'user_id',
        'title', 
        'slug',
        'body',
        'image'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Auto generate slug dari title
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->slug = \Str::slug($article->title);
        });

        static::updating(function ($article) {
            $article->slug = \Str::slug($article->title);
        });
    }
}
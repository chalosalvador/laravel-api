<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
//    protected $table = 'posts';

    protected $fillable = ['title', 'body', 'image'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->user_id = Auth::id();
        });
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','article_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}

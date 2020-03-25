<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['text'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->user_id = auth()->user()->id;
        });
    }

    public function article()
    {
        $this->belongsTo('App\Article','article_id','id');
    }

    public function user()
    {
        $this->belongsTo('App\User','user_id','id');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{

    protected $fillable = ['text'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->user_id = Auth::id();;
        });
    }

    public function article()
    {
        return $this->belongsTo('App\Article','article_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
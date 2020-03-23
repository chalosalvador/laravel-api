<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
//    protected $table = 'comments';
    public function article()
    {
        $this->belongsTo('App\Article','article_id','id');
    }

    public function user()
    {
        $this->belongsTo('App\User','user_id','id');
    }
}
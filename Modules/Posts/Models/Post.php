<?php

namespace Modules\Posts\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Models\Media;
use Modules\Users\Models\Comment;
use Modules\Users\Models\User;

class Post extends Model
{
    protected $table = 'posts';

    protected $guarded = ['id'];

    public function media()
    {
        return $this->belongsToMany(Media::class,'post_media');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userLikes()
    {
        return $this->belongsToMany(User::class,'post_likes','post_id','user_id')
            ->withPivot('status','user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}

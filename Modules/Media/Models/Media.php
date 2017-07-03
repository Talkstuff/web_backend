<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Posts\Models\Post;
use Modules\Users\Models\Comment;
use Modules\Users\Models\User;

class Media extends Model
{
    const IMAGE_TYPE = 1;
    const VIDEO_TYPE = 2;
    const MUSIC_TYPE = 3;

    const PRIVACY_PRIVATE = 1;
    const PRIVACY_FRIENDS = 2;
    const PRIVACY_PUBLIC = 3;


    protected $table = 'media';

    protected $guarded = ['id'];

    protected $casts = [
        'blocked' => 'boolean',
        'featured' => 'boolean'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_media');
    }

    public function categories()
    {
        return $this->belongsToMany(MediaCategory::class,'media_category_pivot',
            'media_id','category_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function getPrivacy()
    {
        switch ($this->privacy){
            case self::PRIVACY_PRIVATE:
                return 'Private';
            case self::PRIVACY_FRIENDS:
                return 'Friends';
            case self::PRIVACY_PUBLIC:
                return 'Public';
        }
    }

    public function getMediaType()
    {
        switch ($this->type){
            case self::IMAGE_TYPE:
                return 'Image';
            case self::VIDEO_TYPE:
                return 'Video';
            case self::MUSIC_TYPE:
                return 'Music';
        }
    }
}

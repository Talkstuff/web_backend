<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class MediaCategory extends Model
{
    const IMAGE_TYPE = 1;
    const VIDEO_TYPE = 2;
    const MUSIC_TYPE = 3;

    protected $guarded = ['id'];

    protected $table = 'media_categories';

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class,'media_category_pivot',
            'category_id','media_id');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/25/2017
 * Time: 5:14 PM
 */

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;
use Modules\Media\Models\Media;

class MediaComment extends Model
{
    protected $table = 'media_comments';

    protected $guarded = ['id'];

    protected $casts = [
        'blocked' => 'boolean'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class,'media_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

}
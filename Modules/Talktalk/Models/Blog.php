<?php

namespace Modules\Talktalk\Models;

use Illuminate\Database\Eloquent\Model;
use LeeOvery\WordpressToLaravel\Post;

class Blog extends Post
{
    protected $table = 'blogs';
}

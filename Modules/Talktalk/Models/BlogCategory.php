<?php

namespace Modules\Talktalk\Models;

use Illuminate\Database\Eloquent\Model;
use LeeOvery\WordpressToLaravel\Category;

class BlogCategory extends Category
{
    protected $table = 'blog_categories';
}

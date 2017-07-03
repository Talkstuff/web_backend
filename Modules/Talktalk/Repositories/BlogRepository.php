<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 23/06/2017
 * Time: 04:59 PM
 */

namespace Modules\Talktalk\Repositories;


use Modules\Talktalk\Models\Blog;

class BlogRepository
{
    /**
     * @var Blog
     */
    private $blog;


    /**
     * BlogRepository constructor.
     * @param Blog $blog
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function getBlogs()
    {
        return $this->blog->latest()->paginate(10);
    }
}
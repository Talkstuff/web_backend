<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 23/05/2017
 * Time: 10:35 PM
 */

namespace Modules\Users\Repositories;


use Modules\Users\Models\Comment;

class CommentRepository
{
    /**
     * @var Comment
     */
    private $comment;


    /**
     * CommentRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param $commentId
     * @return Comment
     */
    public function findById($commentId)
    {
        return $this->comment->find($commentId);
    }
}
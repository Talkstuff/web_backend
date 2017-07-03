<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Users\Repositories\GroupRepository;
use Modules\Users\Transformers\GroupTransformer;

class GroupsController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * GroupsController constructor.
     * @param GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function fetchGroups()
    {
        return transform($this->groupRepository->getAllGroups(), new GroupTransformer());
    }
}

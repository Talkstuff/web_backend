<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 31/05/2017
 * Time: 02:17 PM
 */

namespace Modules\Users\Repositories;


use Modules\Users\Models\Group;

class GroupRepository
{
    /**
     * @var Group
     */
    private $group;


    /**
     * GroupRepository constructor.
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * @param $groupId
     * @return Group
     */
    public function findById($groupId)
    {
        return $this->group->find($groupId);
    }

    /**
     * @return Group
     */
    public function getDefaultGroup()
    {
        return $this->group->whereName('iStars')->first();
    }

    public function getAllGroups()
    {
        return $this->group->latest()->orderBy('name','asc')->get();
    }
}
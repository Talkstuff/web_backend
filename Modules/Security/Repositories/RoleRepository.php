<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 11/05/2017
 * Time: 10:15 AM
 */

namespace Modules\Security\Repositories;


use Modules\Security\Models\Role;
use Modules\Security\Models\RoleCategory;

class RoleRepository
{
    /**
     * @var Role
     */
    private $role;
    /**
     * @var RoleCategory
     */
    private $roleCategory;


    /**
     * RoleRepository constructor.
     * @param Role $role
     * @param RoleCategory $roleCategory
     */
    public function __construct(Role $role, RoleCategory $roleCategory)
    {
        $this->role = $role;
        $this->roleCategory = $roleCategory;
    }

    /**
     * @param $id
     * @return Role
     */
    public function findById($id)
    {
        return $this->role->find($id);
    }

    /**
     * ROLE CATEGORIES
     *
     */

    /**
     * @param array $payLoad
     * @return RoleCategory
     */
    public function saveRoleCategory(array $payLoad)
    {
        $id = isset($payLoad['id']) ? $payLoad['id'] : null;

        if($id){
            $category = $this->roleCategory->find($id);
        } else {
            $category = $this->roleCategory->newInstance();
        }

        $category->fill([
            'name' => $payLoad['name'],
            'reserved' => isset($payLoad['reserved']) ? $payLoad['reserved'] : false,
        ]);

        $category->save();

        return $category;
    }

    /**
     * gets a role category
     * @param $name
     * @return RoleCategory
     */
    public function getCategoryByName($name)
    {
        return $this->roleCategory->whereName($name)->first();
    }


    /**
     *
     *  ROLE
     */

    /**
     * @param array $payLoad
     * @return Role
     */
    public function saveRole(array $payLoad)
    {
        $id = isset($payLoad['id']) ? $payLoad['id'] : null;

        if($id){
            $role = $this->role->find($id);
        } else {
            $role = $this->role->newInstance();
        }

        $role->fill([
            'name' => $payLoad['name'],
            'description' => $payLoad['description']
        ]);

        $role->save();

        return $role;
    }

    /**
     * @param $name
     * @return Role
     */
    public function getRoleByName($name)
    {
        return $this->role->whereName($name)->first();
    }

    public function getAllRoles()
    {
        return $this->role->where('name', '!=','DEV_ROLE')->get();
    }

    /**
     * @param $roleId
     * @return Role
     */
    public function getRoleById($roleId)
    {
        return $this->role->find($roleId);
    }

    public function getRolesInCategory($category_id)
    {
        return $this->role->whereCategoryId($category_id)->latest()->get();
    }

    public function getCategories()
    {
        return $this->roleCategory->latest()->get();

    }

}
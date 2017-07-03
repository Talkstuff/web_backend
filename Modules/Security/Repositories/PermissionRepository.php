<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 07/06/2017
 * Time: 03:26 PM
 */

namespace Modules\Security\Repositories;


use Modules\Security\Models\Permission;
use Modules\Security\Models\PermissionCategory;

class PermissionRepository
{
    /**
     * @var Permission
     */
    private $permission;
    /**
     * @var PermissionCategory
     */
    private $category;


    /**
     * PermissionRepository constructor.
     * @param Permission $permission
     * @param PermissionCategory $category
     */
    public function __construct(Permission $permission, PermissionCategory $category)
    {
        $this->permission = $permission;
        $this->category = $category;
    }


    public function getPermissionByName($category_id, $name)
    {
        return $this->permission->whereCategoryId($category_id)->whereName($name)->first();
    }

    public function savePermission(array $payLoad)
    {
        $editMode = isset($payLoad['id']) && $payLoad['id'] ? true : false;

        $permission = $this->permission->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $permission->fill([
            'name' => $payLoad['name'],
            'description' => $payLoad['description'],
        ]);

        $permission->save();

        return $permission;
    }

    public function getCategories()
    {
        return $this->category->latest()->get();
    }

    public function getPermissions()
    {
        return $this->permission->orderBy('name', 'asc')->get();
    }

    public function deleteCategoryById($category_id)
    {
        return $this->category->whereId($category_id)->delete();
    }

    public function deletePermissionById($permission_id)
    {
        return $this->permission->whereId($permission_id)->delete();

    }

    /**
     * @param $name
     * @return PermissionCategory
     */
    public function getCategoryByName($name)
    {
        return $this->category->whereName($name)->first();
    }
}
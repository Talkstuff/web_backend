<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Security\Models\PermissionCategory;
use Modules\Security\Repositories\PermissionRepository;
use Modules\Security\Transformers\PermissionCategoryTransformer;
use Modules\Security\Transformers\PermissionTransformer;

class PermissionsController extends Controller
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * PermissionsController constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function fetchCategories()
    {
        $categories = $this->permissionRepository->getCategories();

        return transform($categories, new PermissionCategoryTransformer());

    }

    public function deletePermission($permission_id)
    {
        return $this->permissionRepository->deletePermissionById($permission_id);
    }


    public function fetchPermissions()
    {
        $permissions = $this->permissionRepository->getPermissions();

        return transform($permissions, new PermissionTransformer());

    }
    public function savePermission()
    {
        // only validate when we are not editing a permission
        $this->validate(request(), [
            'name' => 'required'
        ]);

        $permission = $this->permissionRepository->savePermission(request()->all());

        return transform($permission, new PermissionTransformer());
    }
}

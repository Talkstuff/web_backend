<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Security\Models\Role;
use Modules\Security\Repositories\RoleRepository;
use Modules\Security\Repositories\RolesRepository;
use Modules\Security\Transformers\RoleCategoryTransformer;
use Modules\Security\Transformers\RolesTransformer;

class RolesController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $rolesRepository;

    /**
     * RolesController constructor.
     * @param RoleRepository $rolesRepository
     */
    public function __construct(RoleRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    public function fetchRoles()
    {
        $roles = $this->rolesRepository->getAllRoles();

        return transform($roles, new RolesTransformer());
    }

    public function saveRole()
    {
        $response = $this->rolesRepository->saveRole(request()->all());

        if($response instanceof Role) return transform($response, new RolesTransformer());

        return $response;
    }

    public function deleteRole($roleId){
        $role = $this->rolesRepository->getRoleById($roleId);

        $role->delete();

        return $role;

    }

    public function fetchRole($roleId)
    {
        $role = $this->rolesRepository->getRoleById($roleId);

        return transform($role, new RolesTransformer());

    }

    public function fetchCategories()
    {
        $categories = $this->rolesRepository->getCategories();

        return transform($categories, new RoleCategoryTransformer());

    }
}

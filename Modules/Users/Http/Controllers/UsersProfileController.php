<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Users\Repositories\UsersRepository;
use Modules\Users\Transformers\UsersTransformer;

class UsersProfileController extends Controller
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * UsersProfileController constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getUserProfile()
    {
        $user = getJwtUser();

        return transform($user, new UsersTransformer());
    }

    public function updateUserBasicProfile()
    {
        // return request()->all();

        $id = \request()->get('id');

        $user = $this->usersRepository->editProfile($id, request()->all());

        return transform($user, new UsersTransformer());
    }

}

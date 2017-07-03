<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Posts\Transformers\PostTransformer;
use Modules\Security\Models\User;
use Modules\Users\Repositories\UsersRepository;
use Modules\Users\Transformers\UsersTransformer;

class UsersController extends Controller
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;


    /**
     * UsersController constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function findUser($id)
    {
        $user = $this->usersRepository->findById($id);

        return transform($user, new UsersTransformer());
    }

    public function getUserByUsername($username)
    {
        $user = $this->usersRepository->findByUsername($username);

        return transform($user, new UsersTransformer());
    }

    public function getUserByUsernameViaEncryption($username)
    {
        $user = $this->usersRepository->findEncryptedByUsername($username, request()->get('e'));

        return transform($user, new UsersTransformer());
    }

    public function getUsers()
    {
        $paginate = request()->has('page') ? : false;

        $users = $this->usersRepository->getUsers($paginate);

        if(!$paginate)  return transform($users, new UsersTransformer());

        return [
            'users' => transform($users->items(), new UsersTransformer()),
            'per_page' => $users->perPage(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage()
        ];
    }

    public function getStartUpFriends($user_id){
        return transform($this->usersRepository->getStartUpFriends($user_id), new UsersTransformer());
    }

    public function registerUserStage1()
    {
        $id = request()->get('id');

        if(!$id) {
            // validation for new record
            $this->validate(request(),[
                'firstName' => 'required',
                'lastName' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
        } else {
            // validation for updating a record
            $this->validate(request(),[
                'firstName' => 'required',
                'lastName' => 'required',
                // 'username' => 'required|unique:users',
                // 'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
        }

        return transform($this->usersRepository->saveUserStageOne(request()->all()), new UsersTransformer());
    }

    public function setupCommunity($user_id)
    {
        // todo:: connect user to friends (users) in 'iStars' group
        $user = $this->usersRepository->setupDefaultFriends($user_id);

        return [
            'user' => transform($user, new UsersTransformer()),
            'friends' => $user->myFriends()
        ];
    }

    public function registerUserStage2()
    {
        // return request()->all();

        $this->validate(request(),[
            'phone' => 'required',
            'state' => 'required',
            'dateOfBirth' => 'required',
            'gender' => 'required',
        ]);

        return transform($this->usersRepository->saveUserStageTwo(request()->all()), new UsersTransformer());
    }

    public function registerUserStage4()
    {
        $user = $this->usersRepository->findById(\request()->get('userId'));

        $user->update(['metadata->profileMediaSource' => \request()->get('profileMedia')['source']]);

        return transform($user, new UsersTransformer());
    }


    public function getUserFeeds($id)
    {
        $feeds = $this->usersRepository->getUserFeeds($id);

        return [
            'feeds' => transform($feeds->items(), new PostTransformer($id)),
            'next_page_url' => $feeds->nextPageUrl()
        ];
    }

    public function getUserTimeline($id)
    {
        $feeds = $this->usersRepository->getUserTimeline($id);

        // id of the user requesting this timeline
        $requestUserId = request()->get('requestByUserId') ? request()->get('requestByUserId') : $id;

        return [
            'feeds' => transform($feeds->items(), new PostTransformer($requestUserId)),
            'next_page_url' => $feeds->nextPageUrl()
        ];
    }

    public function getFriends($id)
    {
        $paginate = request()->has('page') ? (int) request()->get('page') : null;
        $users = $this->usersRepository->findById($id)->myFriends($paginate);

        return [
            'friends' => transform($users->items(), new UsersTransformer()),
            'next_page_url' => $users->nextPageUrl()
        ];
    }

    public function saveRole()
    {
        $userId = \request()->get('id');

        $user = $this->usersRepository->findById($userId);

        $user->roles()->sync(\request()->get('roleIds'));

        return transform($user, new UsersTransformer());
    }


    public function saveGroup()
    {
        $userId = \request()->get('id');

        $user = $this->usersRepository->findById($userId);

        $user->groups()->sync(\request()->get('groupIds'));

        return transform($user, new UsersTransformer());
    }

    public function searchUsers($query)
    {
        $users = $this->usersRepository->searchUser($query);

        return [
            'users' => transform($users->items(), new UsersTransformer()),
            'per_page' => $users->perPage(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage()
        ];
    }

    public function searchFriends($id, $query)
    {
        $friends = $this->usersRepository->searchFriends($id, $query);

        return transform($friends, new UsersTransformer());
    }
}

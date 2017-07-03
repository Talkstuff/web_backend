<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 15/05/2017
 * Time: 05:20 PM
 */

namespace Modules\Users\Repositories;


use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Modules\Posts\Models\Post;
use Modules\Users\Events\UserProfileUpdated;
use Modules\Users\Events\UserWasRegistered;
use Modules\Users\Models\Comment;
use Modules\Users\Models\User;

class UsersRepository
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Comment
     */
    private $comment;
    /**
     * @var DB
     */
    private $db;

    /**
     * UsersRepository constructor.
     * @param User $user
     * @param Comment $comment
     * @param DB $db
     */
    public function __construct(User $user, Comment $comment, DatabaseManager $db)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->db = $db;
    }

    public function getUsers($paginate = false)
    {

        if($paginate) {
            return $this->user
                ->orderBy('first_name','asc')
                ->orderBy('username','asc')
                ->latest()
                ->paginate($paginate ? 50 : null);
        } else {
            return $this->user->all();
        }
    }

    public function saveUser(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var User $user
         */
        $user = $this->user->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $user->fill([
            'display_name' => isset($payLoad['displayName']) ? $payLoad['displayName'] : '',
            'first_name' => $payLoad['firstName'],
            'last_name' => $payLoad['lastName'],
            'username' => $payLoad['username'],
            'email' => $payLoad['email'],
        ]);

        if(!$editMode){
            $user->fill([
                'registered_date' => date('Y-m-d'),
            ]);
        }

        if(isset($payLoad['password'])) $user->fill(['password' => bcrypt($payLoad['password'])]);

        $user->save();

        // fire an event when creating a new user
        if(!$editMode) event(new UserWasRegistered($user, $payLoad));

        return $user;
    }


    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        return $this->user->find($id);
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function getUserFeeds($id)
    {
        $ids = $this->findById($id)->myFriends()->pluck('id')->toArray();

        $ids[] = (int)$id;

        return app(Post::class)->whereIn('user_id', $ids)->latest()->simplePaginate(10);

    }

    public function saveUserStageOne(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var User $user
         */
        $user = $this->user->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $user->fill([
            'first_name' => $payLoad['firstName'],
            'last_name' => $payLoad['lastName'],
            'username' => $payLoad['username'],
            'email' => $payLoad['email'],
        ]);

        if(!$editMode){
            $user->fill([
                'registered_date' => date('Y-m-d'),
            ]);
        }

        if(isset($payLoad['password'])) $user->fill(['password' => bcrypt($payLoad['password'])]);

        $user->save();

        // fire an event when creating a new user
        if(!$editMode) event(new UserWasRegistered($user, $payLoad));

        return $user;

    }

    public function saveUserStageTwo(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var User $user
         */
        $user = $this->findById($payLoad['id']);

        $user->fill([
            'state_id' => $payLoad['state'],
            'gender' => $payLoad['gender'],
            'phone' => $payLoad['phone'],
            'birth_date' => $payLoad['dateOfBirth'],
        ]);

        $user->save();

        return $user;
    }

    public function getStartUpFriends($user_id)
    {
        return $this->user->where('id','<>',$user_id)->get();
    }

    /**
     * @return User
     */
    public function getTalkstuffUser()
    {
        return $this->findByUsername('talkstuff');
    }

    public function setupDefaultFriends($user_id)
    {
        $user = $this->findById($user_id);

        /**
         * @var GroupRepository $groupRepo
         */
        $groupRepo = app(GroupRepository::class);

        $defaultGroup = $groupRepo->getDefaultGroup();

        $talkstuff = $this->getTalkstuffUser();

        $usersIngroup = $defaultGroup->users()
            ->where('users.id', '<>', $talkstuff->id)
            ->get()->pluck('id');

        $friendIdsInGroup = $usersIngroup->random($usersIngroup->count() > 10 ? 10 : $usersIngroup->count());

        foreach ($friendIdsInGroup as $friendId) {
            $this->makeFriend($user_id, $friendId);
        }

        // connect user to talkstuff
        $this->makeFriend($user_id, $talkstuff->id);

        return $user;
    }

    public function makeFriend($user_id, $friend_id)
    {
        // todo:: user makes a friend
        $user = $this->findById($user_id);
        $user->friends()->syncWithoutDetaching([$friend_id]);

        // todo:: friend accepts and friends user
        $friend = $this->findById($friend_id);
        $friend->friends()->syncWithoutDetaching([$user_id]);
    }

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username)
    {
        return $this->user->whereUsername($username)->first();

    }

    public function findEncryptedByUsername($username, $encryption)
    {
        $user = $this->findByUsername($username);

        if(($user->getRequestEncryption() == $encryption) &&
            (date('Y-m-d H:i:s A') <= $user->getEncryptionExpiration())) return $user;

        return null;
    }

    public function getUserTimeline($id)
    {
        return app(Post::class)->where('user_id', $id)->latest()->simplePaginate(10);
    }

    public function editProfile($id, $payLoad)
    {
        $user = $this->findById($id);

        $data = [];

        if($payLoad['firstName']) $data['first_name'] = $payLoad['firstName'];
        if($payLoad['lastName']) $data['last_name'] = $payLoad['lastName'];
        if($payLoad['username']) $data['username'] = $payLoad['username'];
        // if($payLoad['state']) $data['state_id'] = $payLoad['state'];
        if($payLoad['gender']) $data['gender'] = $payLoad['gender'];
        if(isset($payLoad['dateOfBirth']) && $payLoad['dateOfBirth']) $data['birth_date'] = $payLoad['dateOfBirth'];
        if($payLoad['phone']) $data['phone'] = $payLoad['phone'];
        if($payLoad['email']) $data['email'] = $payLoad['email'];

        $user->fill($data);

        $user->save();

        event(new UserProfileUpdated($user));

        return $user;
    }

    public function attachUserToRole(User $user, $roleId)
    {
        $user->roles()->attach($roleId);
    }

    public function searchUser($query)
    {
        $q = $this->user
            ->orWhere('first_name', 'LIKE' ,"%$query%")
            ->orWhere('last_name', 'LIKE' ,"%$query%")
            ->orWhere('email', 'LIKE' ,"%$query%")
            ->orWhere('phone', 'LIKE' ,"%$query%")
            ->orWhere('username', 'LIKE' ,"%$query%")
        ;

        return $q->paginate(50);

    }

    public function searchFriends($user_id, $query)
    {
        return $this->user
            ->find($user_id)
            ->orWhere('first_name', 'LIKE' ,"%$query%")
            ->orWhere('last_name', 'LIKE' ,"%$query%")
            ->orWhere('email', 'LIKE' ,"%$query%")
            ->orWhere('phone', 'LIKE' ,"%$query%")
            ->orWhere('username', 'LIKE' ,"%$query%")
            ->get()
        ;

    }
}
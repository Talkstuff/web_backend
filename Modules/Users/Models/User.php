<?php

namespace Modules\Users\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Media\Models\Media;
use Modules\Posts\Models\Post;
use Modules\Security\Models\Role;
use Modules\Wallet\Models\Wallet;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $dates = [
        'birth_date',
        'registered_date'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'user_groups');
    }

    public function friends()
    {
        return $this->belongsToMany(self::class,'user_connections', 'user_id', 'friend');
    }

    /*public function friendsInverseConnection()
    {
        return $this->belongsToMany(self::class,'user_connections', 'friend', 'user_id');
    }*/

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function groupsBelongingTo()
    {
        return $this->belongsToMany(Group::class,'user_groups','user_id','group_id');
    }

    // friend requests received
    public function friendRequests()
    {
        return $this->hasMany(self::class,'target');
    }

    public function sentRequests()
    {
        return $this->hasMany(self::class,'sender');
    }

    public function getMetadataAttribute($value){
        if($value){
            return json_decode($value, true);
        } else {
            return [];
        }
    }

    public function getFeeds()
    {
        return $this->posts()->latest()->get();
    }

    public function postLikes()
    {
        return $this->belongsToMany(Post::class,'post_likes','user_id','post_id')
            ->withPivot('post_id');
    }

    public function fullName()
    {
        $lastname = $this->last_name ? ' ' . $this->last_name : null;

        return $this->first_name . $lastname;
    }

    public function getDisplayName()
    {
        return $this->display_name ? $this->display_name : $this->fullName();
    }

    public function getTotalFriends()
    {
        return $this->myFriends()->unique('id')->count();
    }

    public function myFriends($paginate = null)
    {
        if($paginate) {
            $friends = $this->friends()->simplePaginate(12);
        } else {
            $friends = $this->friends()->get();
        }

        return $friends;
    }

    public function setRequestEncryption()
    {
        $encryption = str_random(20);

        $this->update(['metadata->encryption_key' => $encryption]);

        return $encryption;
    }

    public function setEncryptionExpiration()
    {
        $expires = Carbon::now()->addHours(2)->format('Y-m-d H:i:s A');

        $this->update(['metadata->encryption_expiration' => $expires]);

        return $expires;
    }

    public function getRequestEncryption(){
        return $this->metadata['encryption_key'];
    }

    public function getEncryptionExpiration(){
        return $this->metadata['encryption_expiration'];
    }

    public function allPermissions()
    {
        // todo:: gets all permissions for this staff
        return [];
    }

    public function wallets(){
        return $this->hasMany(Wallet::class,'user_id');
    }

    public function medias(){
        return $this->hasMany(Media::class,'user_id');
    }
}

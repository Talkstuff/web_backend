<?php

namespace Modules\Staff\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Modules\Security\Models\Role;

class Staff extends Authenticatable
{
    protected $table = 'staffs';

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'staff_role');
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function allPermissions()
    {
        // todo:: gets all permissions for this staff
        return [];
    }
}

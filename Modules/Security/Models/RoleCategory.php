<?php

namespace Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

class RoleCategory extends Model
{
    protected $table = 'role_categories';

    protected $guarded = ['id'];

    protected $casts = [
        'reserved' => 'boolean'
    ];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}

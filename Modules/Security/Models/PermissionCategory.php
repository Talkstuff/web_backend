<?php

namespace Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    protected $guarded = ['id'];

    protected $table = 'permission_categories';

    protected $casts = [
        'reserved' => 'boolean'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}

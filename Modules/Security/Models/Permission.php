<?php

namespace Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }
}

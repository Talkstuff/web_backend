<?php

namespace Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Staff\Models\Staff;

class Role extends Model
{
    protected $table = 'roles';

    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsTo(RoleCategory::class);
    }

    public function staffs()
    {
        return $this->belongsToMany(Staff::class,'staff_role');
    }

}

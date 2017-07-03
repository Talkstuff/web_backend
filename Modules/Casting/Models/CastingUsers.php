<?php

namespace Modules\Casting\Models;

use Illuminate\Database\Eloquent\Model;

class CastingUsers extends Model
{
    protected $table = 'wptl_users';
    protected $connection = 'casting-db';

    protected $guarded = ['id'];

    public $timestamps = false;
}

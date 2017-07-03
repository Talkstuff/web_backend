<?php

namespace Modules\Talktalk\Models;

use Illuminate\Database\Eloquent\Model;

class WpUsers extends Model
{
    protected $table = 'wpfy_users';
    protected $connection = 'talktalk-db';

    protected $guarded = ['id'];

    public $timestamps = false;
}

<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $guarded = ['id'];

    protected $casts = [
        'reserved' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_groups','group_id','user_id');
    }

    public function ownedByUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getMetadataAttribute($value){
        if($value){
            return json_decode($value, true);
        } else {
            return [];
        }
    }
}

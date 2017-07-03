<?php

namespace Modules\Casting\Models;

use Illuminate\Database\Eloquent\Model;

class CastCategory extends Model
{
    protected $table = 'cast_categories';

    public function casts()
    {
        return $this->hasMany(Cast::class,'category_id');
    }


}

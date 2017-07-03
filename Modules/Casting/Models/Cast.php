<?php

namespace Modules\Casting\Models;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $table = 'casts';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(CastCategory::class,'category_id');
    }
}

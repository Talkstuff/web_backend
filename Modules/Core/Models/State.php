<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = ['id'];

    protected $table = 'states';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

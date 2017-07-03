<?php

namespace Modules\Afr\Models;

use Illuminate\Database\Eloquent\Model;

class AfrApplicationType extends Model
{
    protected $table = 'afr_application_types';

    // refers to applicants of a particular type => photography, blogger
    public function applicants()
    {
        return $this->hasMany(AfrApplicant::class, 'type_id');
    }
}

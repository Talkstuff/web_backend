<?php

namespace Modules\Afr\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class AfrApplicant extends Model
{
    protected $table = 'afr_applicants';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function type()
    {
        return $this->belongsTo(AfrApplicationType::class, 'type_id');
    }

    public function attachments()
    {
        return $this->hasMany(AfrMediaAttachment::class,'applicant_id');
    }
}

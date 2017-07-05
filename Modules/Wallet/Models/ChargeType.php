<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeType extends Model
{
    //
    protected $table = 'deposits';
    protected $guarded = ['id'];

    public function getChargeTypes(){}

}

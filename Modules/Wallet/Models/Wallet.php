<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;
use Modules\Wallet\Models\WalletType;
use Modules\Wallet\Models\Deposit;

class Wallet extends Model
{
    //
    protected $table = 'wallets';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function wallet_type(){
        return $this->belongsTo(WalletType::class, 'wallet_type_id');
    }

    public function deposits(){
        return $this->hasMany(Deposit::class,'wallet_id');
    }

}

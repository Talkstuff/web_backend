<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    protected $table = 'wallet_type';

    protected $guarded = ['id'];

    public function getCurrencyName(){
        return $this->currencyName;
    }

    public function getCurrencySymbol(){
        return $this->currencySymbol;
    }

    public function getCurrencyAbbre(){
        return $this->abbreviation;
    }

    public function wallets(){
        return $this->hasMany(Wallet::class,'wallet_type');
    }


}

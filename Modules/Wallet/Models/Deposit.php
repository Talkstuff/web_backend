<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    protected $table = 'deposits';
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet(){
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

    public function getById($id){
        return $this->find($id)->first();
    }

    public function updateDeposit($id,$attr,$value){
        return $this->getById($id)
            ->update([$attr => $value]);
    }

    public function saveDeposit(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var Deposit $Deposit
         */
        $Deposit = $this->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $Deposit->fill([
            'wallet_id' => $payLoad['walletId'],
            'amount' => floatval($payLoad['amount']),
            'deposit_channel' => $payLoad['channel'],
            'status'=>'Cleared',
            'status_date'=>date('Y-m-d h:i:s A'),
            'status_details'=>'New',
            'metadata' => \GuzzleHttp\json_encode($payLoad['metadata'])
        ]);
        $Deposit->save();
        return $Deposit;
    }

    public function incrementWalletBalance($deposit_id){
        $deposit=$this->getById($deposit_id);
        $wallet=$deposit->wallet()->get();
        //still working
    }

}

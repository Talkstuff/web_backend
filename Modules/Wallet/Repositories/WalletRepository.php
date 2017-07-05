<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/12/2017
 * Time: 10:30 AM
 */

namespace Modules\Wallet\Repositories;


use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Modules\Users\Models\User;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Events\WalletCreated;
use Modules\Wallet\Models\Deposit;

class WalletRepository
{
    /**
     * @var $Wallet
     */
    private $Wallet;
    /**
     * @var DB
     */
    private $db;

    /**
     * @var $Deposit
     */
    private $Deposit;

    /**
     * WalletTypeRepository constructor.
     * @param Wallet $Wallet
     * @param DB $db
     */
    public function __construct(Wallet $Wallet, DatabaseManager $db, Deposit $Deposit)
    {
        $this->wallet = $Wallet;
        $this->deposit=$Deposit;
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->wallet->all();
    }

    public function getUserWallets($id){
        return User::find($id)->wallets()->get();
    }

    public function saveWallet(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var Wallet $Wallet
         */
        $Wallet = $this->wallet->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $Wallet->fill([
            'user_id' => $payLoad['userId'],
            'wallet_type_id' => $payLoad['typeId'],
            'title' => $payLoad['label'],
            'status'=>'Cleared',
            'statusDate'=>date('Y-m-d h:i:s A'),
            'statusDetails'=>'New',
            'metadata' => $payLoad['mData']
        ]);
        $Wallet->save();

        // fire an event when creating a new user
        if(!$editMode) event(new WalletCreated($Wallet, $payLoad));

        return $Wallet;
    }

    public function getWalletById($id){
        return $this->wallet->where('id', '=', $id)->get();
    }

    public function deleteWallet($id){
        return $this->wallet->where('id', '=', $id)->delete();
    }

    public function updateWalletMetadata($id,$column,$att,$value){
        return $this->wallet
            ->where('id', $id)
            ->update([$column .'->'.$att => $value]);
    }

    public function getWalletDeposits($id){
        return $this->wallet->find($id)->deposits()->get();
    }

}
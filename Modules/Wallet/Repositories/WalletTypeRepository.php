<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 15/05/2017
 * Time: 05:20 PM
 */

namespace Modules\Wallet\Repositories;


use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Modules\Wallet\Models\WalletType;
use Modules\Wallet\Models\Wallet;

class WalletTypeRepository
{
    /**
     * @var $WalletType
     */
    private $WalletType;
    /**
     * @var DB
     */
    private $db;

    /**
     * WalletTypeRepository constructor.
     * @param WalletType $WalletType
     * @param DB $db
     */
    public function __construct(WalletType $WalletType, DatabaseManager $db)
    {
        $this->walletType = $WalletType;
        $this->db = $db;
    }

    public function getWalletTypes($limit = null)
    {
        return $this->walletType->all();
    }

    public function saveWalletType(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var User $user
         */
        $WalletType = $this->walletType->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $WalletType->fill([
            'currencyName' => $payLoad['curName'],
            'currencySymbol' => $payLoad['curSym'],
            'title' => $payLoad['label'],
            'abbreviation' => $payLoad['abbre']
        ]);
        $WalletType->save();

        // fire an event when creating a new user
        if(!$editMode) event(new WalletTypeRegistered($WalletType, $payLoad));

        return $WalletType;
    }


    /**
     * @param $id
     * @return WalletType
     */
    public function findById($id)
    {
        return $this->walletType->find($id);
    }

    public function getWalletsOfAType($id)
    {
        return $this->findById($id)->wallets()->latest()->simplePaginate(3);

    }


}
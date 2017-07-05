<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/12/2017
 * Time: 6:06 PM
 */

namespace Modules\Wallet\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Wallet\Transformers\DepositsTransformer;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Models\Deposit;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Transformers\WalletTransformer;

class WalletsController extends Controller
{
    /**
     * @var WalletRepository
     */
    private $walletRepository;


    /**
     * WalletController constructor.
     * @param WalletRepository $walletRepository
     */
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function findWallet($id)
    {
        $wallet = $this->walletRepository->getWalletById($id);

        return transform($wallet, new WalletTransformer());
    }

    public function getUserWallets($user_id)
    {
        return transform($this->walletRepository->getUserWallets($user_id), new WalletTransformer());
    }

    public function getWallets(){
        return transform($this->walletRepository->getAll(), new WalletTransformer());
    }

    public function updateMetadata($id,$column,$att,$value){
        return transform($this->walletRepository->updateWalletMetadata($id,$column,$att,$value), new WalletTransformer());
    }

    public function createWallet()
    {
        $this->validate(request(),[
            'userId' => 'required',
            'typeId' => 'required',
            'label' => 'required',
            'mdata' => 'required',
        ]);

        return transform($this->walletRepository->saveWallet(request()->all()), new WalletTransformer());
    }

    public function getWalletDeposits($wallet_id)
    {
        $deposits = $this->walletRepository->getWalletDeposits($wallet_id);

        return [
            'deposits' => transform($deposits->items(), new DepositsTransformer()),
            'next_page_url' => $deposits->nextPageUrl()
        ];
    }
}

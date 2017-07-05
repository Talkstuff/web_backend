<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/13/2017
 * Time: 4:04 AM
 */

namespace Modules\Wallet\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Wallet\Transformers\DepositsTransformer;
use Modules\Wallet\Models\Deposit;

class DepositsController extends Controller
{
    /**
     * @var Deposit
     */
    private $dep;


    /**
     * WalletController constructor.
     * @param Deposit $deposit
     */
    public function __construct(Deposit $deposit)
    {
        $this->dep = $deposit;
    }

    public function createDeposit()
    {
        $this->validate(request(),[
            'wallet_id' => 'required',
            'deposit_channel' => 'required',
            'amount' => 'required',
            'metadata' => 'required',
        ]);

        return transform($this->dep->saveDeposit(request()->all()), new DepositsTransformer());
    }

}

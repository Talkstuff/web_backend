<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/13/2017
 * Time: 2:57 AM
 */

namespace Modules\Wallet\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Wallet\Models\Deposit;

class DepositsTransformer extends TransformerAbstract
{
    public function transform(Deposit $deposit)
    {
        return [
            'id' => $deposit->id,
            'purseId' => $deposit->wallet_id,
            'via' => $deposit->deposit_channel,
            'cash' => $deposit->amount,
            'mData' => $deposit->metadata,
            'state' => $deposit->status,
            'details' => $deposit->status_details,
            'staD' => $deposit->status_date
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/12/2017
 * Time: 6:27 PM
 */

namespace Modules\Wallet\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Wallet\Models\Wallet;

class WalletTransformer extends TransformerAbstract
{
    public function transform(Wallet $wallet)
    {
        return [
            'id' => $wallet->id,
            'userId' => $wallet->user_id,
            'typeId' => $wallet->wallet_type_id,
            'label' => $wallet->title,
            'mData' => $wallet->metadata,
            'state' => $wallet->status,
            'details' => $wallet->statusDetails,
            'staD' => $wallet->statusDate
        ];
    }

}
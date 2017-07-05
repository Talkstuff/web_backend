<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/11/2017
 * Time: 5:44 PM
 */

namespace Modules\Wallet\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Wallet\Models\WalletType;

class WalletTypeRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var WalletType
     */
    public $WalletType;
    /**
     * @var array
     */
    public $payLoadData;

    /**
     * Create a new event instance.
     * @param WalletType $WalletType
     * @param array $payLoadData
     */
    public function __construct(WalletType $WalletType, array $payLoadData)
    {
        //
        $this->walletType = $WalletType;
        $this->payLoadData = $payLoadData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Wallet_Type');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/11/2017
 * Time: 4:35 PM
 */

namespace Modules\Wallet\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Users\Models\User;
use Modules\Wallet\Models\WalletType;
use Illuminate\Database\Eloquent\Model;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = User::all()->pluck('id')->toArray();
        $types=WalletType::all()->pluck('id')->toArray();
        for ($x = 0; $x < count($types); $x++) {
            for($y=0; $y < count($ids); $y++){
                \DB::table('wallets')->insert([
                    'user_id' => $ids[$y],
                    'wallet_type_id' => $types[$x],
                    'title' => str_random(18),
                    'status'=>'Cleared',
                    'statusDate'=>Date('Y-m-d'),
                    'statusDetails'=>'New',
                    'metadata' => Null
                ]);
            }
        }

    }

}
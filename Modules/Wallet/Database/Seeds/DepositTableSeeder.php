<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/11/2017
 * Time: 4:36 PM
 */
namespace Modules\Wallet\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Model;

class DepositTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = Wallet::all()->pluck('id')->toArray();
        for ($x = 0; $x < count($ids); $x++) {
            for($y=0; $y < 9; $y++){
                \DB::table('deposits')->insert([
                    'wallet_id' => $ids[$x],
                    'amount' => floatval(rand(2000,150000)),
                    'deposit_channel' => 'Bank Transfer',
                    'status'=>'Cleared',
                    'status_date'=>date('Y-m-d H:i:s'),
                    'status_details'=>'New',
                    'metadata' => json_encode(['sender'=>'ayo','dateTime'=>'20/12/2017 4:00am','accId'=>'234562748','FromBank'=>'EcoBank'])
                ]);
            }
        }
    }
}

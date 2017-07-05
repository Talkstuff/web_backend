<?php

namespace Modules\Wallet\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class WalletDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("SET foreign_key_checks=0");
        Model::unguard();

        $this->call(WalletTypeTableSeeder::class);
        $this->call(WalletTableSeeder::class);
        $this->call(DepositTableSeeder::class);
        $this->call(TransferTypeTableSeeder::class);

        \DB::statement("SET foreign_key_checks=1");
    }
}

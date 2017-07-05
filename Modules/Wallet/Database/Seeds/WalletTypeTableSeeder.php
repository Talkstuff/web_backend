<?php

namespace Modules\Wallet\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class WalletTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('wallet_type')->insert([
            'currencyName' => 'USDollar',
            'currencySymbol' => '$',
            'title' => 'USDollar tsWallet',
            'abbreviation'=>'USD'
        ]);
        \DB::table('wallet_type')->insert([
            'currencyName' => 'Naira',
            'currencySymbol' => '₦',
            'title' => 'Naira tsWallet',
            'abbreviation'=>'NGN'
        ]);
        \DB::table('wallet_type')->insert([
            'currencyName' => 'Euro',
            'currencySymbol' => '€',
            'title' => 'Euro tsWallet',
            'abbreviation'=>'USD'
        ]);
        \DB::table('wallet_type')->insert([
            'currencyName' => 'UKPound',
            'currencySymbol' => '£',
            'title' => 'UKPound tsWallet',
            'abbreviation'=>'GBP'
        ]);
    }
}

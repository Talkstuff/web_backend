<?php

namespace Modules\Core\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Core\Models\Country;
use Modules\Core\Models\State;
use Modules\Core\Repositories\CountriesRepository;

class CoreDatabaseSeeder extends Seeder
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

        State::truncate();
        Country::truncate();

        $countries = [
            'Nigeria',
            'Ghana',
            'South Africa',
            'United Kingdom',
            'United States',
            'Singapore',
        ];

        foreach ($countries as $country){
            app(CountriesRepository::class)->saveCountry($country);
        }

        /// todo:: nigeria states
        $states = [
            'Abia',
            'Adamawa',
            'Akwa-Ibom',
            'Anambra',
            'Bauchi',
            'Bayelsa',
            'Benue',
            'Borno',
            'Cross-River',
            'Delta',
            'Edo',
            'Enugu',
            'Ebonyi',
            'Ekiti',
            'Federal Capital Territory',
            'Gombe',
            'Imo',
            'Jigawa',
            'Kano',
            'Kaduna',
            'Katsina',
            'Kebbi',
            'Kogi',
            'Kwara',
            'Lagos',
            'Nassarawa',
            'Niger',
            'Ondo',
            'Osun',
            'Ogun',
            'Oyo',
            'Plateau',
            'Rivers',
            'Sokoto',
            'Taraba',
            'Yobe',
            'Zamfara'
        ];

        $nigeria = app(CountriesRepository::class)->getCountryByName();

        foreach ($states as $state){
            app(CountriesRepository::class)->saveState($nigeria->id, $state);
        }

        Model::reguard();
        \DB::statement("SET foreign_key_checks=1");

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 03/06/2017
 * Time: 12:59 PM
 */

namespace Modules\Core\Repositories;


use Modules\Core\Models\Country;
use Modules\Core\Models\State;

class CountriesRepository
{
    /**
     * @var Country
     */
    private $country;
    /**
     * @var State
     */
    private $state;


    /**
     * CountriesRepository constructor.
     * @param Country $country
     * @param State $state
     */
    public function __construct(Country $country, State $state)
    {
        $this->country = $country;
        $this->state = $state;
    }

    /**
     * @param string $name
     * @return Country
     */
    public function getCountryByName($name = 'Nigeria')
    {
        return $this->country->whereName($name)->first();
    }

    /**
     * @param $name
     * @return Country
     */
    public function saveCountry($name)
    {
        return $this->country->firstOrCreate(['name'=>$name]);
    }

    /**
     * @param $name
     * @return Country
     */
    public function saveState($country_id, $name)
    {
        return $this->state->firstOrCreate(['name'=>$name,'country_id'=>$country_id]);
    }
}
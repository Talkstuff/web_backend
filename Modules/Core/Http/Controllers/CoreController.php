<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\Country;

class CoreController extends Controller
{
    public function getCountries(Country $country)
    {
        $countries = $country->orderBy('name', 'asc')->get();

        return $countries;
    }

    public function getStates($countryId, Country $country)
    {
        return $country->find($countryId)->states()->orderBy('name','ASC')->get();
    }
}

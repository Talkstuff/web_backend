<?php

namespace Modules\Site\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{

    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        \Theme::setActive('site');
    }

    public function home()
    {
        return \Theme::view('pages.home');
    }
}

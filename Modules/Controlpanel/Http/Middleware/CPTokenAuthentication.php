<?php

namespace Modules\Controlpanel\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class CPTokenAuthentication
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * ControlPanelAuthentication constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($this->auth->guard());
        if ($this->auth->guard('controlPanelApi')->guest()) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}

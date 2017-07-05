<?php

namespace Modules\Security\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Security\Jobs\ForgotPasswordJob;
use Modules\Security\Mail\ForgotPassword;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;
use Modules\Users\Transformers\UsersTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $platformGuard;

    protected $redirectPath = '/adminpanel';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        \Theme::setActive('controlPanel');
    }


    public function showLoginForm()
    {
        return \Theme::view('security.login');

    }

    public function securityLogin()
    {
        return $this->login(request());
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if($request->ajax()){
            return response()->json([
                'user' => \Auth::user(),
                'message' => 'Successfully logged in',
            ]);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    protected function validateLogin(Request $request)
    {
        if($request->ajax()){
            $validator = \Validator::make($request->all(),[
                $this->username() => 'required', 'password' => 'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'hasError' => true,
                    'errors' => [
                        $validator->errors()->getMessages(),
                    ],
                    'message' => 'Failed login validation. You must have omitted a required field.'
                ],401);
            }

        }
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if($request->ajax()){
            return response()->json([
                'hasError' => true,
                'message' => 'Invalid username and/or password',
            ],422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function guard($guard = 'web')
    {
        return \Auth::guard($guard);
    }

    public function username()
    {
        return 'username';
    }

    public function jwtLogin()
    {
        $this->validate(request(),[
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = request()->only('username','password');

        try {
            // attempt to verify the credentials and create a token for the user
            if(filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)) {
                //user sent their email
                $loggedIn = $this->guard('web')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']]);
            } else {
                //they sent their username instead
                $loggedIn = $this->guard('web')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']]);
            }

            if(!$loggedIn) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            /*if (! $token = \JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }*/
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = \Auth::user();

        $token = \JWTAuth::fromUser($user, ['user' => transform($user, new UsersTransformer())]);

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getJwtUser()
    {
        try {

            if (! $user = \JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        //return $user;
        $user = transform($user, new UsersTransformer());
        return response()->json(compact('user'));
    }

    public function forgotPassword()
    {
        $email = request()->get('email');

        $user = app(UsersRepository::class)->findByEmail($email);

        dispatch((new ForgotPasswordJob($user))->onConnection('redis'));

        return response()->json([$email]);
    }

    public function resetPassword(UsersRepository $usersRepository)
    {
        $this->validate(request(), [
            'new_password' => 'required',
            'retype_password' => 'required|same:new_password'
        ]);

        $user_id = \request()->get('user_id');

        $user = $usersRepository->findById($user_id);

        $user->update(['password' => bcrypt(request()->get('new_password'))]);

        return transform($user, new UsersTransformer());
    }
}

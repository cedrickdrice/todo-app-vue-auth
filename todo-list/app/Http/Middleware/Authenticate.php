<?php

namespace App\Http\Middleware;

use App\Constants\ResponseConstants;
use App\Libraries\ResponseLibrary;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;


class Authenticate extends Middleware
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    protected $JWTAuth;

    protected $guard;

    const REQUEST_API = 'api';

    const REQUEST_WEB = 'web';

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @param JWTAuth $JWTAuth
     */
    public function __construct(Auth $auth, JWTAuth $JWTAuth)
    {
        $this->auth = $auth;
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param String $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $guard = null)
    {
        if ($guard === self::REQUEST_API) {
            $bIsRequestHasToken = $this->JWTAuth->parser()->setRequest($request)->hasToken();
            if ($bIsRequestHasToken === true) {
                try {
                    auth('api')->setRequest($request)->authenticate();
                    return $next($request);
                } catch (\Exception $e) {
                    return ResponseLibrary::errorResponse('Invalid access_token (invalid_token)', ResponseConstants::UNAUTHORIZED_REQUEST);
                }
            }
            return ResponseLibrary::errorResponse('Enter access_token. (invalid_request)', ResponseConstants::UNAUTHORIZED_REQUEST);
        }

        // Try authenticating using the Auth user guard
        if ($this->auth->guard($guard)->check() === false) {
            throw new AuthenticationException('Unauthenticated.', [$guard], $this->redirectTo($request));
        }

        return $next($request);
    }

}

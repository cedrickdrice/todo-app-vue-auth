<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\ResponseConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Libraries\ResponseLibrary;
use App\Repository\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $oUserRepository;

    public function __construct(UserRepositoryInterface $oUserRepository)
    {
        $this->oUserRepository = $oUserRepository;
    }

    /**
     * Login API request
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        $oRegisteredUser = $this->oUserRepository->getUserByColumnName('email', $loginRequest->get('email'));
        if ($oRegisteredUser->exists() === false) {
            return ResponseLibrary::errorResponse(
                [
                    'email' => ['Email not found']
                ],
                ResponseConstants::NOT_FOUND);
        }

        $mToken = Auth::guard('api')->attempt($this->credentials($loginRequest));
        if ($mToken === false) {
            return ResponseLibrary::errorResponse('Invalid Email or Password', ResponseConstants::INVALID_PARAMETER_REQUEST);
        }

        return ResponseLibrary::successDataResponse([
            'access_token'  => $mToken,
            'token_type'    => 'bearer',
            'user'          => auth('api')->user(),
            'expires_in'    => Carbon::now()->addMinutes(auth('api')->factory()->getTTL())->timestamp
        ]);
    }

    /**
     * Logout user and remove token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $requestWithToken = auth('api')->setRequest($request);
        $requestWithToken->logout();
        return ResponseLibrary::successResponse('User has been logged out', ResponseConstants::NO_CONTENT_REQUEST);
    }

    /**
     * @todo remove
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetail(Request $request)
    {
        try {
            //try this, to check if still valid
//            $this->validate($request, [
//                'token' => 'required'
//            ]);
//            $user = JWTAuth::authenticate($request->token);

            return ResponseLibrary::successDataResponse([
                'access_token'  => auth('api')->setRequest($request)->refresh()
            ]);
        } catch(TokenBlacklistedException $e) {
            return ResponseLibrary::errorResponse('Invalid access_token (invalid_token', ResponseConstants::UNAUTHORIZED_REQUEST);
        }
    }

    /**
     * Get credential from request
     * @param Request $request
     * @return array
     */
    public function credentials(Request $request): array
    {
        return [
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ];
    }
}

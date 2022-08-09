<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Libraries\ResponseLibrary;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Hash;

class RegisterController extends Controller
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
     * Register User
     * @param RegisterRequest $oRegisterRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $oRegisterRequest): JsonResponse
    {
        $aRegisterFormRequest = $oRegisterRequest->validated();
        $oRegisteredUser = $this->oUserRepository->create([
            'name'   => $aRegisterFormRequest['name'],
            'email'         => $aRegisterFormRequest['email'],
            'password'      => Hash::make($aRegisterFormRequest['password']),
        ]);

        return ResponseLibrary::successDataResponse([
            'User'   => $oRegisteredUser,
        ]);
    }
}

<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());
            return ResponseTrait::responseSuccess($data,'User registered successfully.');
        } catch (Exception $exception) {
            return ResponseTrait::responseError([],$exception->getMessage());
        }
    }
}

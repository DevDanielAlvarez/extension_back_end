<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register User
     * @param Request $request
     * @return void
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        //get validated fields
        $data = $request->validated();
        //create dto to create user
        $dto = new UserDto(
            name: $data['name'],
            registration_number: '', // empty, will be set by observer
            password: $data['password']
        );
        //create user using service layer
        $userCreated = UserService::create($dto);
        //generate auth token
        $token = $userCreated->getRecord()->createToken('auth_token')->plainTextToken;
        //return user and token
        return response()->json([
            'user' => UserResource::make($userCreated->getRecord()),
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}

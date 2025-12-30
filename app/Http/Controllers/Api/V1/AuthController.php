<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login the user
     * @param LoginRequest $request - fields: [registration_number, password]
     * @return void
     */
    public function login(LoginRequest $request): JsonResponse
    {
        //get validated data from http request
        $validatedData = $request->validated();
        //find the user based in registration number passed in http request 
        $user = User::where('registration_number', $validatedData['registration_number'])->first();
        //the user must exists and the password must correct
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()
                ->json([
                    'message' => 'Invalid credentials'
                ]);
        }
        // if the user exists and the password is correct, create a new token to login user using sanctum
        $token = $user->createToken('auth_token')->plainTextToken;
        //return the user and token found
        return response()
            ->json([
                'message' => 'Login successfully',
                'user' => UserResource::make($user),
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
    }
    /**
     * Register User
     * @param Request $request
     * @return void
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request): JsonResponse {
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
        });
    }
}

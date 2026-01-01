<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;
use DB;

class AuthController extends Controller
{
    /**
     * Authenticate user
     * 
     * Authenticates a user using registration number and password,
     * returning a Bearer token for authenticated requests.
     *
     * @param LoginRequest $request - Required fields: [registration_number, password]
     * @return JsonResponse Authentication token and user data
     */
    #[OA\Post(
        path: '/api/v1/login',
        summary: 'Authenticate user',
        description: 'Authenticates user based on registration number and password',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            description: 'User credentials',
            required: true,
            content: new OA\JsonContent(
                required: ['registration_number', 'password'],
                properties: [
                    new OA\Property(
                        property: 'registration_number',
                        type: 'string',
                        description: 'User registration number',
                        example: '202410001'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        description: 'User password',
                        format: 'password',
                        example: 'password123'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'User login successful',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Login successfully'),
                        new OA\Property(
                            property: 'user',
                            type: 'object',
                            description: 'Authenticated user data'
                        ),
                        new OA\Property(
                            property: 'token',
                            type: 'string',
                            description: 'Bearer token for authentication',
                            example: '1|AbCdEfGhIjKlMnOpQrStUvWxYz'
                        ),
                        new OA\Property(
                            property: 'token_type',
                            type: 'string',
                            example: 'Bearer'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid credentials')
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error - required fields missing',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            description: 'Validation errors'
                        )
                    ]
                )
            )
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        // get validated data from http request
        $validatedData = $request->validated();
        // find the user based in registration number passed in http request
        $user = User::where('registration_number', $validatedData['registration_number'])->first();
        // the user must exists and the password must correct
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()
                ->json([
                    'message' => 'Invalid credentials'
                ], 401);
        }
        // if the user exists and the password is correct, create a new token to login user using sanctum
        $token = $user->createToken('auth_token')->plainTextToken;
        // return the user and token found
        return response()
            ->json([
                'message' => 'Login successfully',
                'user' => UserResource::make($user),
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
    }

    /**
     * Register new user
     * 
     * Creates a new user account with provided credentials
     * and returns a Bearer token for immediate access.
     *
     * @param RegisterRequest $request - Required fields: [name, password, password_confirmation]
     * @return JsonResponse New user data and authentication token
     */
    #[OA\Post(
        path: '/api/v1/register',
        summary: 'Register new user',
        description: 'Creates a new user and returns authentication token',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            description: 'Data for creating new user',
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        description: 'User full name',
                        example: 'John Silva'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        description: 'Password (minimum 8 characters)',
                        format: 'password',
                        example: 'password123'
                    ),
                    new OA\Property(
                        property: 'password_confirmation',
                        type: 'string',
                        description: 'Password confirmation (must match password)',
                        format: 'password',
                        example: 'password123'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'User created successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'User created Successfully'),
                        new OA\Property(
                            property: 'user',
                            type: 'object',
                            description: 'Created user data'
                        ),
                        new OA\Property(
                            property: 'token',
                            type: 'string',
                            description: 'Bearer token for authentication',
                            example: '1|AbCdEfGhIjKlMnOpQrStUvWxYz'
                        ),
                        new OA\Property(
                            property: 'token_type',
                            type: 'string',
                            example: 'Bearer'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error - invalid data',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            description: 'Validation errors'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Internal server error',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Internal Server Error')
                    ]
                )
            )
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request): JsonResponse {
            // get validated fields
            $data = $request->validated();
            // create dto to create user
            $dto = new UserDto(
                name: $data['name'],
                registration_number: '',  // empty, will be set by observer
                password: $data['password']
            );
            // create user using service layer
            $userCreated = UserService::create($dto);
            // generate auth token
            $token = $userCreated->getRecord()->createToken('auth_token')->plainTextToken;
            // return user and token
            return response()->json([
                'message' => 'User created Successfully',
                'user' => UserResource::make($userCreated->getRecord()),
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        });
    }

    /**
     * logout auth user
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        //delete current acess token
        $request->user()->currentAccessToken()->delete();
        //return message
        return response()->json([
            'message' => 'Secessfully logged out'
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Actions\Auth\RegisterUserAction;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication endpoints"
 * )
 */

final class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     description="Allows a new user to register by providing necessary details such as name, email, password, and role. Upon successful registration, an access token is returned for authentication.",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/RegisterRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful registration",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="accessToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="tokenType", type="string", example="Bearer"),
     *             @OA\Property(property="expiresAt", type="string", format="date-time", example="2023-12-31T23:59:59Z"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *
     *     @OA\Response(response=400, description="Bad request - Invalid input data"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     )
     * )
     */
    public function register(RegisterRequest $request , RegisterUserAction $action): JsonResponse
    {
        $user = $action->handle($request->validated(), $request->string('role')->value());

        $token = $user->createToken('auth_token');

        return response()->json([
            'accessToken' => $token->plainTextToken,
            'tokenType' => 'Bearer',
            'expiresAt' => $token->accessToken->expires_at,
            'user' => UserResource::make($user),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login a user",
     *     description="Authenticates a user by validating their credentials (email/phone/username and password). If successful, an access token is returned for subsequent authenticated requests.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/LoginRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="accessToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="tokenType", type="string", example="Bearer"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {

        $user = User::query()
            ->when($request->input('email'), function ($query) use ($request) {
                return $query->where('email', $request->string('email')->value());
            })
            ->when($request->input('phone'), function ($query) use ($request) {
                return $query->where('phone', $request->string('phone')->value());
            })
            ->when($request->input('username'), function ($query) use ($request) {
                return $query->where('username', $request->string('username')->value());
            })
            ->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->string('password')->value(), $user->password)) {
            // Check if the user is banned
            if ($user->is_banned) {
                return response()->json(
                    ['error' => 'Your account is banned. Please contact your administrator.'],
                    ResponseAlias::HTTP_FORBIDDEN
                );
            }

            return response()->json([
                'accessToken' => $user->createToken('auth_token')->plainTextToken,
                'tokenType' => 'Bearer',
                'user' => UserResource::make($user),
            ]);
        }

        return response()->json(
            ['message' => 'Unauthorized'],
            ResponseAlias::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout a user",
     *     description="Logs out the currently authenticated user by invalidating their access token. This ensures that the token can no longer be used for authenticated requests.",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=204,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = $credentials['user'];
        $user = User::where('username', $user)
            ->orWhere('email', $user)
            ->first();

        if (!$user) {
            return $this::formatLoginErrorResponse('Wrong username / email.', 'user', 'The provided username / email is incorrect.');
        }

        if (!Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            return $this::formatLoginErrorResponse('Wrong password.', 'password', 'The provided password is incorrect.');
        }
        $token = null;
        if ($user->hasRole('admin')) {
            $token = $user->createToken('auth_token', [
                'admin',
            ])->plainTextToken;
        } else {
            $token = $user->createToken('auth_token', [
                'user',
            ])->plainTextToken;
        }
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([ 'message' => 'Logged out succesfully'], 201);
    }


    // helper functions

    /**
     * Formats a JSON error response for login failures.
     *
     * This function creates a JSON response object with a standardized format
     * for login error messages. It includes a general message, a specific error
     * field related to the failure, and a more detailed error description.
     *
     * @param string $message The general error message to be displayed.
     * @param string $error_field The specific field where the error occurred (e.g., "username", "password").
     * @param string $error_detail A more detailed description of the error.
     * @return JsonResponse The formatted JSON error response object.
     * @throws \InvalidArgumentException If any of the parameters are missing or invalid.
     */
    public static function formatLoginErrorResponse(string $message, string $error_field, string $error_detail): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'errors' => [
                    $error_field => $error_detail
                ]
            ],
            403
        );
    }
}

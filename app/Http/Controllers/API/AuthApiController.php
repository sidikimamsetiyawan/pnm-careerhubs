<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    /**
     * Login.
     */
    public function login(Request $request)
    {
        try {
            // $request->validate([
            //     'email' => 'email|required',
            //     'password' => 'required'
            // ]);

            // $credentials = request(['email', 'password']);
            // if (!Auth::attempt($credentials)) {
            //     return response()->json([
            //         'status' => true,
            //         'message' => 'Authentication failed.',
            //         'result' => null
            //     ], 500);
            // }

            // $user = User::where('email', $request->email)->first();
            // if (!Hash::check($request->password, $user->password, [])) {

            // }

            // $tokenResult = $user->createToken('create_token')->plainTextToken;

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Successfully login.',
            //     'result' => $credentials,
            //     'access_token' => $tokenResult,
            //     'token_type' => 'Bearer'
            // ], 200);
            // Validate the request input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            // Check if user exists and verify the password
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            // Generate the token
            $tokenResult = $user->createToken('create_token')->plainTextToken;

            // Return a successful response with the token
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged in.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve users.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Revoke the user's current access token
        $user->currentAccessToken()->delete();

        // Return a response indicating successful logout
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out.',
        ], 200);
    }
}

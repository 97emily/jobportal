<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\PostMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'role' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        }

        try {
            if (Role::where('name', $request->input('role'))->exists()) {
                $password = Str::random(8);

                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($password),
                ]);

                $user->assignRole($request->input('role'));

                $details = [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => $password,
                    'login_url' => url('/admin/profile')
                ];

                try {
                    Mail::to($validatedData['email'])->send(new PostMail($details));
                } catch (\Exception $e) {
                    Log::error('Email sending failed: ' . $e->getMessage());
                    return response()->json(['message' => 'Email sending failed. Please try again later.'], 500);
                }

                $token = $user->createToken($validatedData['email'] . 'AppName')->plainTextToken;

                $response = [
                    'status' => 'success',
                    'message' => 'New User created successfully!',
                    'payload' => [
                        'token' => $token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $request->input('role'),
                    ],
                ];

                return response()->json($response, 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops, "' . $request->input('role') . '" does not exist!',
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userRoles = $user->getRoleNames();
            $tokenName = $credentials['email'] . 'AppName';
            $token = $user->createToken($tokenName)->plainTextToken;

            $response = [
                'status' => 'success',
                'message' => 'User login successful!',
                'payload' => [
                    'token' => $token,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $userRoles,
                ],
            ];

            return response()->json($response, 200);
        } else {
            $userExists = User::where('email', $credentials['email'])->exists();

            if (!$userExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User does not exist!',
                ], 404);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Incorrect password!',
                ], 401);
            }
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'status' => 'success',
            'message' => 'Log out successful!',
        ];
        return response()->json($response, 200);
    }

    public function socialLogin(Request $request)
    {
        // Handle social login using Socialite
        // Retrieve user information from social provider
        // Create user if not exists, then generate and return access token
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['status' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['status' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}

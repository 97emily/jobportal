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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public static function resourceClassName()
    {
        return 'Role';
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'role' => 'required|string',
            ]);
        } catch (ValidationException $e) {
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

    // Role Management Methods

    public function index(Request $request): JsonResponse
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return response()->json([
            'success' => true,
            'data' => $roles,
            'pagination' => [
                'current_page' => $roles->currentPage(),
                'last_page' => $roles->lastPage(),
                'per_page' => $roles->perPage(),
                'total' => $roles->total()
            ]
        ]);
    }

    public function create(): JsonResponse
    {
        $permissions = Permission::all();

        return response()->json([
            'success' => true,
            'data' => $permissions
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id', // Check if each permission ID exists in the permissions table
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the new role
        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'web'
        ]);

        // Sync permissions to the role
        $role->syncPermissions($request->input('permission'));

        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'role' => $role,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'role' => $role,
                'permissions' => $rolePermissions
            ]
        ]);
    }

    public function edit($id): JsonResponse
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions;

        return response()->json([
            'success' => true,
            'data' => [
                'role' => $role,
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions
            ]
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validate = self::checkValidation($request, 'update');
        if ($validate !== true) {
            return $validate;
        }

        $role = Role::find($id);
        $role->update($request->all());
        $role->syncPermissions(Permission::find($request->input('permission')));

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.'
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
        }

        $role->delete();

        return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
    }

    private static function checkValidation($request, $type = 'create')
    {
        $rules = $type === 'create' ? self::createRules() : self::updateRules();

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ], 422);
        }

        return true;
    }

    private static function createRules()
    {
        return [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];
    }

    private static function updateRules()
    {
        return [
            'name' => 'required',
            'permission' => 'required',
        ];
    }
}

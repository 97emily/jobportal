<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);

        return view('admin.users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):RedirectResponse
    {

        $password = Str::random(8);

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|same:confirm_password',
            'roles' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $input = $request->all();
        $input['password'] = Hash::make($password);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        // Prepare email details
        $details = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $password,
            'login_url' => url('/admin/profile')
            // 'update_url'=>url('profile.update')
        ];

        try {
            // Send email
            Mail::to($input['email'])->send(new WelcomeMail($details));
        } catch (\Exception $e) {
            // Handle the error
            Log::error('Email sending failed: ' . $e->getMessage());
            // You might also want to notify the user about the error
            return redirect()->back()->with(['message' => 'Email sending failed. Please try again later.'], 500);
        }

        return redirect()->back()->with(['success' => true, 'message' => 'User is created successfully.']);
    }

    // return redirect()->back()->with(['success' => true, 'message' => $message]);

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm_password',
            'roles' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        User::find($id)->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
}

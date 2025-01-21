<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->filter(User::class, [], ['name', 'email']);

        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($users),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create($request->validated());
                $user->roles()->sync($request->get('roles'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', 'User created');
    }

    public function show(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('id'),
            'roles' => Role::all(),
        ]);
    }

    public function edit(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('id'),
            'roles' => Role::all(),
        ]);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        try {
            DB::transaction(function () use ($user, $request) {
                $data = $request->validated();
                $password = $data['password'] ?? null;
                if (!$password) {
                    unset($data['password']);
                }
                $user->update($data);
                $user->roles()->sync($request->get('roles'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated');
    }

    public function destroy($id)
    {
         User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();

        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
        if (request('email')) {
            $query->where('email', 'like', '%' . request('email') . '%');
        }

        $users = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render('Users/Index', [
            'users' => UserResource::collection($users),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
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
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('users.index')->with('success', 'User created');
    }

    public function show(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Users/Show', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('id'),
            'roles' => Role::all(),
        ]);
    }

    public function edit(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return Inertia::render('Users/Edit', [
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
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('users.index')->with('success', 'User updated');
    }

    public function destroy($id)
    {
         User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'User deleted');
    }
}

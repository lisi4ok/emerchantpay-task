<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RolesController extends Controller
{
    public function index(): Response
    {
        $query = Role::query();

        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        $roles = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render('Roles/Index', [
            'roles' => RoleResource::collection($roles),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Roles/Create', [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return redirect()->route('roles.index')->with('success', 'Role created');
    }

    public function show(int $id): Response
    {
        $role = Role::with('permissions')->findOrFail($id);

        return Inertia::render('Roles/Show', [
            'role' => $role,
        ]);
    }

    public function edit(int $id): Response
    {
        $role = Role::with('permissions')->findOrFail($id);

        return Inertia::render('Roles/Edit', [
            'role' => $role,
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()->route('roles.index')->with('success', 'Roles updated');
    }

    public function destroy(int $id): RedirectResponse
    {
        Role::findOrFail($id)->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted');
    }
}

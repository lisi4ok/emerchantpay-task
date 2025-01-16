<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RolesController extends Controller
{
    public function index()
    {
        $roles = $this->filter(Role::class, [], ['name']);

        return Inertia::render('Admin/Roles/Index', [
            'roles' => RoleResource::collection($roles),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Roles/Create', [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $role = Role::create(['name' => $request->validated('name')]);
                $role->permissions()->sync($request->get('permissions'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created');
    }

    public function show(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return Inertia::render('Admin/Roles/Show', [
            'role' => $role,
            'permissions' => $role->permissions,
        ]);
    }

    public function edit(int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return Inertia::render('Admin/Roles/Edit', [
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('id'),
            'permissions' => Permission::all(),
        ]);
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        try {
            DB::transaction(function () use ($role, $request) {
                $role->update(['name' => $request->validated('name')]);
                $role->permissions()->sync($request->get('permissions'));
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated');
    }

    public function destroy($id)
    {
         Role::findOrFail($id)->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted');
    }
}

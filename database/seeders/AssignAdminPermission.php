<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RoleEnum;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class AssignAdminPermission extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * @return void
     * @throw \RuntimeException
     */
    public function run(): void
    {
        try {
            $user = User::first();
            $role = Role::where(['name' => Str::title(RoleEnum::ADMINISTRATOR->name)])->first();

            $hasRole = \DB::table('users_roles')->where(['user_id' => $user->id, 'role_id' => $role->id])->first();
            if ($hasRole === null) {
                \DB::table('users_roles')->insert(['user_id' => $user->id, 'role_id' => $role->id]);
            }

            $hasPermissions = \DB::table('roles_permissions')->where(['role_id' => $role->id])->count();
            if ($hasPermissions === 0) {
                $permissions = Permission::all()->pluck('id')->toArray();
                $insert = [];
                foreach ($permissions as $key => $permission) {
                    $insert[$key]['permission_id'] = $permission;
                    $insert[$key]['role_id'] = $role->id;
                }
                \DB::table('roles_permissions')->insert($insert);
            }
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

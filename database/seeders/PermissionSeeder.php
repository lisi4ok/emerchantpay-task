<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Order;
use App\Models\Trasaction;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class PermissionSeeder extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            //'viewAny',
            'any',
            'view',
            'create',
            'update',
            'delete',
//            'restore',
//            'forceDelete',
        ];
        $models = [
            Str::lower(basename(User::class)),
            Str::lower(basename(Role::class)),
            Str::lower(basename(Permission::class)),
            Str::lower(basename(Order::class)),
            Str::lower(basename(Trasaction::class)),
        ];

        try {
            foreach ($models as $model) {
                foreach ($actions as $action) {
                    $name = $action . ' '  . $model;
                    Permission::firstOrCreate(
                        [
                            'name' => $name,
                        ],
                    );
                }
            }
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

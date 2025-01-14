<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            foreach (RoleEnum::cases() as $role) {
                Role::firstOrCreate(
                    [
                        'id' => $role->value,
                    ],
                    [
                        'name' => Str::title($role->name),
                    ],
                );
            }
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

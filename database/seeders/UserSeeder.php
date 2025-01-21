<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Factories\UserFactory;

class UserSeeder extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            UserFactory::new()->create();
            User::factory()->password(\env('FIRST_USER_PASSWORD'))
                ->coun(10)->create();
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

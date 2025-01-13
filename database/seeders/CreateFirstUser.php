<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class CreateFirstUser extends BaseSeeder
{
    //use WithoutModelEvents;

    /**
     * @return void
     * @throw \RuntimeException
     */
    public function run(): void
    {
        try {
            User::firstOrCreate(
                [
                    'email' => \env('FIRST_USER_EMAIL'),
                ],
                [
                    'name' => Env::getOrFail('FIRST_USER_NAME'),
                    'email_verified_at' => now(),
                    'password' => Hash::make(Env::getOrFail('FIRST_USER_PASSWORD')),
                    'remember_token' => Str::random(10),
                ],
            );
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

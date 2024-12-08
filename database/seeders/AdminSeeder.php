<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeds the database with a default admin user.
 *
 * This seeder creates an admin user with the following details:
 * - Name: admin
 * - Email: admin@gmail.com
 * - Password: password (hashed)
 * - Role: admin
 *
 * Additionally, it generates an API authentication token for the admin user
 * and displays it in the console. This token can be used for initial API testing
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name"=> "admin",
            "email"=> "admin@gmail.com",
            "password"=> 'password'
        ]);
        $user->assignRole(RoleEnum::Admin->value);

        $token = $user->createToken('auth_token')->plainTextToken;
        $this->command->info('Token for auth: ' .$token);
    }
}

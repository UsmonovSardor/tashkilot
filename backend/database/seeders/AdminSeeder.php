<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin
        $admin = User::create([
            'email'          => 'admin@velvethour.com',
            'password'       => Hash::make('VelvetAdmin2024!'),
            'role'           => 'admin',
            'status'         => 'active',
            'email_verified' => true,
        ]);
        UserProfile::create([
            'user_id'    => $admin->id,
            'first_name' => 'VelvetHour',
            'last_name'  => 'Admin',
            'city'       => 'Tashkent',
            'country'    => 'Uzbekistan',
        ]);

        // Demo client accounts
        $clients = [
            ['email' => 'client.male@velvet.demo',   'gender' => 'male',   'first' => 'Alexander', 'last' => 'Petrov'],
            ['email' => 'client.female@velvet.demo',  'gender' => 'female', 'first' => 'Sofia',     'last' => 'Chen'],
        ];

        foreach ($clients as $c) {
            $user = User::create([
                'email'          => $c['email'],
                'password'       => Hash::make('VelvetDemo2024!'),
                'role'           => 'client',
                'status'         => 'active',
                'email_verified' => true,
            ]);
            UserProfile::create([
                'user_id'    => $user->id,
                'first_name' => $c['first'],
                'last_name'  => $c['last'],
                'gender'     => $c['gender'],
                'city'       => 'Tashkent',
                'country'    => 'Uzbekistan',
            ]);
        }

        $this->command->info('✓ Seeded admin + 2 demo client accounts');
    }
}

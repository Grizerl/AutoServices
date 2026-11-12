<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates the first administrator.
 *
 * Credentials come from ADMIN_EMAIL / ADMIN_PASSWORD. Outside production a
 * development default (admin@auto.local / password) is used; in production the
 * seeder refuses to create an admin without an explicit password.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@auto.local');
        $password = env('ADMIN_PASSWORD') ?: (app()->environment('production') ? null : 'password');

        if (! $password) {
            $this->command?->warn('ADMIN_PASSWORD is not set: skipping the admin user in production.');

            return;
        }

        $admin = User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Administrator', 'password' => $password],
        );

        $admin->assignRole('Admin');
    }
}

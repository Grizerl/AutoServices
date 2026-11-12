<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Sample content so a fresh install does not render an empty site
        if (! app()->environment('production')) {
            $this->call(DemoContentSeeder::class);
        }
    }
}

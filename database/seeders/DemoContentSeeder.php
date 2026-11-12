<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Members;
use App\Models\Post;
use Illuminate\Database\Seeder;

/** Sample site content; only fills tables that are still empty. */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::count() === 0) {
            Post::insert([
                [
                    'title' => 'Engine diagnostics and repair',
                    'content' => 'Full computer diagnostics and repair of engines of any complexity, with a written warranty on every job.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if (Client::count() === 0) {
            foreach ([
                ['Alex Carter', 'Owner of Toyota Camry', 'Fast and high quality work. Thank you to the whole team!'],
                ['Irene Shaw', 'Owner of Skoda Octavia', 'Fair prices and an attentive attitude. I will definitely come back.'],
                ['Andrew Boyd', 'Owner of BMW X5', 'Highly recommended: everything was done on time and explained clearly.'],
            ] as [$name, $role, $comment]) {
                Client::create(['name' => $name, 'role' => $role, 'commentars' => $comment]);
            }
        }

        if (Members::count() === 0) {
            foreach ([
                ['Victor Miller', 'Head mechanic', 42],
                ['Sergey Lane', 'Auto electrician', 35],
                ['Max Fisher', 'Engine specialist', 38],
                ['Dmitry Reed', 'Technician', 29],
            ] as $i => [$name, $role, $age]) {
                Members::create([
                    'name' => $name,
                    'role' => $role,
                    'age' => $age,
                    'phone_number' => '+38050000000'.($i + 1),
                    'place_of_residence' => 'Kyiv',
                    // bundled demo photos live in /public/assets/people
                    'img' => 'assets/people/team-img'.($i + 1).'.jpg',
                ]);
            }
        }
    }
}

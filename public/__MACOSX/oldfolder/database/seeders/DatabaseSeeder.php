<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ONLY permission seeder run
        $this->call([
            PermissionSeeder::class,
        ]);
    }
}
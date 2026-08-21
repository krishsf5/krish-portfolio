<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Nothing to seed — frontend has no database.
 * All data lives on the backend (Neon PostgreSQL via portfolio-backend).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Intentionally empty.
    }
}

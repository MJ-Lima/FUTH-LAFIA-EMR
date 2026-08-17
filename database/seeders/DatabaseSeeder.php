<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * ORDER MATTERS:
     * 1. Permissions first (creates roles + permissions)
     * 2. FuthEmrSeeder second (creates data and assigns roles to users)
     */
    public function run(): void
    {
        // Step 1: Seed all permissions and role-permission mappings
        $this->call([
            FuthPermissionsSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('=== Permissions & Roles ready ===');

        // Step 2: Seed EMR data (hospitals, departments, clinics, users, etc.)
        $this->call([
            FuthEmrSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('=== EMR Data seeded ===');
        $this->command->info('Login: admin@futhlafia.gov.ng / Futh@2026');
    }
}

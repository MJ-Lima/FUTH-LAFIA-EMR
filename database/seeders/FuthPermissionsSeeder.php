<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class FuthPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ---------------------------------------------------------------
        // 1. DEFINE RESOURCES — ONLY those with actual database tables
        //    (removed: drugCategory, dispensingPoint, stockMovement, supplier,
        //     labPanel, labTest, radiologyModality, procedureBooking,
        //     reportTemplate, savedReport, bloodDonation, bloodUnit,
        //     bloodRequest, bloodTransfusion, procedure)
        // ---------------------------------------------------------------
        $resources = [
            // System
            'user',
            // Facility
            'hospital', 'department', 'clinic',
            // Staff & Patients
            'staff', 'patient', 'encounter', 'appointment',
            // Clinical
            'vitals', 'clinicalNote', 'allergy', 'diagnosis',
            // Pharmacy
            'drug', 'drugBatch', 'prescription',
            // Laboratory
            'labOrder',
            // Radiology
            'radiologyOrder',
            // Scheduling
            'dutyRoster', 'dutyPosting',
            // Insurance & Billing
            'insuranceProvider', 'insurancePlan', 'patientInsurance',
            'insuranceClaim', 'preAuthorization',
            'service', 'invoice', 'payment',
            // Wards & Admissions
            'ward', 'bed', 'admission',
            // Blood Bank
            'bloodDonor',
        ];

        // Create 4 CRUD permissions per resource
        foreach ($resources as $resource) {
            foreach (['view', 'create', 'update', 'delete'] as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$resource}", 'guard_name' => 'web']);
            }
        }

        // System-level permissions
        $systemPermissions = [
            'view reportsDashboard',
            'view auditLog',
            'manage settings',
            'manage roles',
            'manage permissions',
            'export data',
            'import data',
            'view any clinic data',
            'view any department data',
        ];

        foreach ($systemPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $this->command->info('Permissions seeded: ' . Permission::count() . ' total.');

        // ---------------------------------------------------------------
        // 2. DEFINE ROLES AND PERMISSION MAPPING
        // ---------------------------------------------------------------
        $rolesConfig = [
            'Super Admin' => [
                'type' => 'full',
            ],
            'Doctor' => [
                'resources' => [
                    'patient', 'encounter', 'appointment',
                    'vitals', 'clinicalNote', 'allergy', 'diagnosis',
                    'prescription', 'labOrder', 'radiologyOrder',
                    'admission', 'ward', 'bed', 'bloodDonor',
                ],
                'extra' => ['view reportsDashboard', 'export data', 'view any clinic data'],
            ],
            'Nurse' => [
                'resources' => [
                    'patient', 'encounter', 'appointment',
                    'vitals', 'clinicalNote', 'allergy',
                    'prescription', 'labOrder',
                    'admission', 'ward', 'bed', 'bloodDonor',
                ],
                'extra' => ['view reportsDashboard'],
            ],
            'Pharmacist' => [
                'resources' => [
                    'patient', 'encounter',
                    'drug', 'drugBatch', 'prescription',
                ],
                'extra' => ['view reportsDashboard', 'export data'],
            ],
            'Laboratory Scientist' => [
                'resources' => [
                    'patient', 'encounter', 'labOrder',
                ],
                'extra' => ['view reportsDashboard'],
            ],
            'Radiographer' => [
                'resources' => [
                    'patient', 'encounter', 'radiologyOrder',
                ],
                'extra' => ['view reportsDashboard'],
            ],
            'Medical Records Officer' => [
                'resources' => [
                    'patient', 'encounter', 'appointment',
                    'vitals', 'clinicalNote', 'diagnosis',
                ],
                'extra' => ['view reportsDashboard', 'export data'],
            ],
            'Accountant' => [
                'resources' => [
                    'patient', 'encounter',
                    'service', 'invoice', 'payment',
                    'insuranceProvider', 'insurancePlan', 'patientInsurance',
                    'insuranceClaim', 'preAuthorization',
                ],
                'extra' => ['view reportsDashboard', 'export data'],
            ],
            'Insurance Officer' => [
                'resources' => [
                    'patient', 'encounter',
                    'insuranceProvider', 'insurancePlan', 'patientInsurance',
                    'insuranceClaim', 'preAuthorization',
                    'service', 'invoice', 'payment',
                ],
                'extra' => ['view reportsDashboard', 'export data'],
            ],
        ];

        foreach ($rolesConfig as $roleName => $config) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            if (($config['type'] ?? '') === 'full') {
                $allPermissions = Permission::all();
                $role->syncPermissions($allPermissions);
                $this->command->info("Role [{$roleName}] -> ALL permissions ({$allPermissions->count()})");
            } else {
                $permissionNames = [];
                foreach ($config['resources'] as $resource) {
                    foreach (['view', 'create', 'update', 'delete'] as $action) {
                        $permissionNames[] = "{$action} {$resource}";
                    }
                }
                if (!empty($config['extra'])) {
                    $permissionNames = array_merge($permissionNames, $config['extra']);
                }
                $existingPerms = Permission::whereIn('name', $permissionNames)->get();
                $role->syncPermissions($existingPerms);
                $this->command->info("Role [{$roleName}] -> {$existingPerms->count()} permissions");
            }
        }

        $this->command->info('Roles and permissions seeded successfully.');
    }
}

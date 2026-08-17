<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FuthPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Syncing FUTH Lafia EMR permissions...');

        // Sync permissions for new resources (filament-shield already created
        // permissions for existing resources during initial install).
        $newResources = [
            'dutyRoster', 'dutyPosting',
            'insuranceProvider', 'insurancePlan', 'patientInsurance',
            'insuranceClaim', 'preAuthorization',
            'service', 'invoice', 'payment',
        ];

        $actions = ['view', 'view_any', 'create', 'update', 'restore', 'restore_any', 'replicate', 'reorder', 'delete', 'delete_any', 'force_delete', 'force_delete_any'];

        foreach ($newResources as $resource) {
            foreach ($actions as $action) {
                $perm = $action . '_' . $resource;
                Permission::firstOrCreate(
                    ['name' => $perm, 'guard_name' => 'web']
                );
            }
        }

        // ---- Roles and permissions mapping ----
        $rolePerms = [
            'Super Admin' => ['*'],
            'Medical Administrator' => [
                'view_any_user', 'view_user', 'create_user', 'update_user', 'delete_user',
                'view_any_hospital', 'view_hospital', 'create_hospital', 'update_hospital',
                'view_any_department', 'view_department', 'create_department', 'update_department',
                'view_any_clinic', 'view_clinic', 'create_clinic', 'update_clinic',
                'view_any_staff', 'view_staff', 'create_staff', 'update_staff',
                'view_any_patient', 'view_patient', 'create_patient', 'update_patient',
                'view_any_encounter', 'view_encounter', 'create_encounter', 'update_encounter',
                'view_any_appointment', 'view_appointment', 'create_appointment', 'update_appointment',
                'view_any_vitals', 'view_vitals', 'create_vitals', 'update_vitals',
                'view_any_clinicalNote', 'view_clinicalNote', 'create_clinicalNote', 'update_clinicalNote',
                'view_any_allergy', 'view_allergy', 'create_allergy', 'update_allergy',
                'view_any_diagnosis', 'view_diagnosis', 'create_diagnosis', 'update_diagnosis',
                'view_any_drug', 'view_drug', 'create_drug', 'update_drug',
                'view_any_drugCategory', 'view_drugCategory', 'create_drugCategory', 'update_drugCategory',
                'view_any_drugBatch', 'view_drugBatch', 'create_drugBatch', 'update_drugBatch',
                'view_any_prescription', 'view_prescription', 'create_prescription', 'update_prescription',
                'view_any_labPanel', 'view_labPanel', 'create_labPanel', 'update_labPanel',
                'view_any_labTest', 'view_labTest', 'create_labTest', 'update_labTest',
                'view_any_labOrder', 'view_labOrder', 'create_labOrder', 'update_labOrder',
                'view_any_radiologyModality', 'view_radiologyModality', 'create_radiologyModality', 'update_radiologyModality',
                'view_any_radiologyOrder', 'view_radiologyOrder', 'create_radiologyOrder', 'update_radiologyOrder',
                'view_any_insuranceProvider', 'view_insuranceProvider', 'create_insuranceProvider', 'update_insuranceProvider',
                'view_any_insurancePlan', 'view_insurancePlan', 'create_insurancePlan', 'update_insurancePlan',
                'view_any_patientInsurance', 'view_patientInsurance', 'create_patientInsurance', 'update_patientInsurance',
                'view_any_insuranceClaim', 'view_insuranceClaim', 'create_insuranceClaim', 'update_insuranceClaim',
                'view_any_preAuthorization', 'view_preAuthorization', 'create_preAuthorization', 'update_preAuthorization',
                'view_any_service', 'view_service', 'create_service', 'update_service',
                'view_any_invoice', 'view_invoice', 'create_invoice', 'update_invoice',
                'view_any_payment', 'view_payment', 'create_payment', 'update_payment',
                'view_any_dutyRoster', 'view_dutyRoster', 'create_dutyRoster', 'update_dutyRoster',
                'view_any_dutyPosting', 'view_dutyPosting', 'create_dutyPosting', 'update_dutyPosting',
            ],
            'Doctor' => [
                'view_any_patient', 'view_patient', 'create_patient', 'update_patient',
                'view_any_encounter', 'view_encounter', 'create_encounter', 'update_encounter',
                'view_any_appointment', 'view_appointment', 'create_appointment', 'update_appointment',
                'view_any_vitals', 'view_vitals', 'create_vitals', 'update_vitals',
                'view_any_clinicalNote', 'view_clinicalNote', 'create_clinicalNote', 'update_clinicalNote',
                'view_any_allergy', 'view_allergy', 'create_allergy', 'update_allergy',
                'view_any_diagnosis', 'view_diagnosis', 'create_diagnosis', 'update_diagnosis',
                'view_any_prescription', 'view_prescription', 'create_prescription', 'update_prescription',
                'view_any_labOrder', 'view_labOrder', 'create_labOrder', 'update_labOrder',
                'view_any_radiologyOrder', 'view_radiologyOrder', 'create_radiologyOrder', 'update_radiologyOrder',
                'view_any_drug', 'view_drug',
                'view_any_labPanel', 'view_labPanel',
                'view_any_labTest', 'view_labTest',
                'view_any_radiologyModality', 'view_radiologyModality',
                'view_any_patientInsurance', 'view_patientInsurance',
                'view_any_insuranceClaim', 'view_insuranceClaim', 'create_insuranceClaim', 'update_insuranceClaim',
                'view_any_preAuthorization', 'view_preAuthorization', 'create_preAuthorization', 'update_preAuthorization',
                'view_any_service', 'view_service',
                'view_any_invoice', 'view_invoice',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Nurse' => [
                'view_any_patient', 'view_patient',
                'view_any_encounter', 'view_encounter', 'update_encounter',
                'view_any_appointment', 'view_appointment',
                'view_any_vitals', 'view_vitals', 'create_vitals', 'update_vitals',
                'view_any_clinicalNote', 'view_clinicalNote', 'create_clinicalNote', 'update_clinicalNote',
                'view_any_allergy', 'view_allergy',
                'view_any_diagnosis', 'view_diagnosis',
                'view_any_prescription', 'view_prescription',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Pharmacist' => [
                'view_any_patient', 'view_patient',
                'view_any_drug', 'view_drug', 'create_drug', 'update_drug',
                'view_any_drugCategory', 'view_drugCategory', 'create_drugCategory', 'update_drugCategory',
                'view_any_drugBatch', 'view_drugBatch', 'create_drugBatch', 'update_drugBatch',
                'view_any_prescription', 'view_prescription', 'create_prescription', 'update_prescription',
                'view_any_dispensingPoint', 'view_dispensingPoint', 'create_dispensingPoint', 'update_dispensingPoint',
                'view_any_stockMovement', 'view_stockMovement', 'create_stockMovement',
                'view_any_supplier', 'view_supplier',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Laboratory Scientist' => [
                'view_any_patient', 'view_patient',
                'view_any_labPanel', 'view_labPanel',
                'view_any_labTest', 'view_labTest',
                'view_any_labOrder', 'view_labOrder', 'create_labOrder', 'update_labOrder',
                'view_any_encounter', 'view_encounter',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Radiographer' => [
                'view_any_patient', 'view_patient',
                'view_any_radiologyModality', 'view_radiologyModality',
                'view_any_radiologyOrder', 'view_radiologyOrder', 'create_radiologyOrder', 'update_radiologyOrder',
                'view_any_encounter', 'view_encounter',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Medical Records Officer' => [
                'view_any_patient', 'view_patient', 'create_patient', 'update_patient',
                'view_any_encounter', 'view_encounter', 'create_encounter',
                'view_any_appointment', 'view_appointment', 'create_appointment', 'update_appointment',
                'view_any_staff', 'view_staff',
                'view_any_clinic', 'view_clinic',
                'view_any_department', 'view_department',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Accountant' => [
                'view_any_patient', 'view_patient',
                'view_any_invoice', 'view_invoice', 'create_invoice', 'update_invoice',
                'view_any_payment', 'view_payment', 'create_payment', 'update_payment',
                'view_any_service', 'view_service',
                'view_any_insuranceClaim', 'view_insuranceClaim', 'create_insuranceClaim', 'update_insuranceClaim',
                'view_any_patientInsurance', 'view_patientInsurance',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
            'Insurance Officer' => [
                'view_any_patient', 'view_patient',
                'view_any_insuranceProvider', 'view_insuranceProvider',
                'view_any_insurancePlan', 'view_insurancePlan',
                'view_any_patientInsurance', 'view_patientInsurance', 'create_patientInsurance', 'update_patientInsurance',
                'view_any_insuranceClaim', 'view_insuranceClaim', 'create_insuranceClaim', 'update_insuranceClaim',
                'view_any_preAuthorization', 'view_preAuthorization', 'create_preAuthorization', 'update_preAuthorization',
                'view_any_invoice', 'view_invoice',
                'view_any_encounter', 'view_encounter',
                'view_any_dutyPosting', 'view_dutyPosting',
            ],
        ];

        foreach ($rolePerms as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            if ($perms === ['*']) {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($perms);
            }
        }

        $this->command->info('Permissions synced.');
    }
}

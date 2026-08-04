<?php

namespace Database\Seeders;

use App\Models\Allergy;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\ClinicalNote;
use App\Models\Department;
use App\Models\Diagnosis;
use App\Models\DispensingPoint;
use App\Models\Drug;
use App\Models\DrugBatch;
use App\Models\DrugCategory;
use App\Models\DrugInteraction;
use App\Models\Encounter;
use App\Models\Hospital;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\LabPanel;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\RadiologyModality;
use App\Models\RadiologyOrder;
use App\Models\RadiologyResult;
use App\Models\Staff;
use App\Models\State;
use App\Models\Local;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Vitals;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Geographical reference data (Nigeria) — international ISO 3166-2:NG
        $this->call([
            \Database\Seeders\NigeriaGeographySeeder::class,
            \Database\Seeders\RolesAndPermissionsSeeder::class,
            \Database\Seeders\HospitalStructureSeeder::class,
            \Database\Seeders\StaffSeeder::class,
            \Database\Seeders\DrugCatalogSeeder::class,
            \Database\Seeders\LabCatalogSeeder::class,
            \Database\Seeders\RadiologySeeder::class,
            \Database\Seeders\SupplierSeeder::class,
            \Database\Seeders\DispensingPointSeeder::class,
            \Database\Seeders\DemoPatientSeeder::class,
        ]);

        $this->command->info('FUTH-Lafia EMR database seeded successfully.');
    }
}

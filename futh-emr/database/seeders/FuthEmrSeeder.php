<?php

namespace Database\Seeders;

use App\Models\{Clinic, Department, DutyPosting, Hospital, InsurancePlan, InsuranceProvider, PatientInsurance, Role};
use App\Models\{Drug, DrugBatch, LabOrder, LabOrderItem, LabPanel, LabResult, LabTest, Patient};
use App\Models\{Service, Staff, User, Vitals};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\{Permission, Role as SpatieRole};

class FuthEmrSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding FUTH Lafia EMR demo data...');

        // ---- 1. Reset all seeded user passwords to a known value ----
        $password = Hash::make('Futh@2026');
        User::query()->update(['password' => $password]);
        $this->command->info('All user passwords set to: Futh@2026');

        // ---- 2. Ensure Insurance Officer role exists ----
        $insuranceRole = SpatieRole::firstOrCreate(
            ['name' => 'Insurance Officer', 'guard_name' => 'web']
        );
        $recordsRole = SpatieRole::firstOrCreate(
            ['name' => 'Medical Records Officer', 'guard_name' => 'web']
        );

        // ---- 3. Add a dedicated Insurance Officer user ----
        $officer = User::firstOrCreate(
            ['email' => 'insurance.officer@futhlafia.gov.ng'],
            [
                'name'           => 'Amina Bello',
                'password'       => $password,
                'hospital_id'    => 1,
                'department_id'  => 1,
                'status'         => 'active',
            ]
        );
        $officer->assignRole($insuranceRole);

        // ---- 4. Staff records for each user (if missing) ----
        $designations = [
            'admin@futhlafia.gov.ng'           => ['System Administrator', 'Administrator'],
            'dr.okoro@futhlafia.gov.ng'        => ['Consultant Physician', 'Doctor'],
            'dr.adebayo@futhlafia.gov.ng'      => ['Consultant Obstetrician', 'Doctor'],
            'nurse.john@futhlafia.gov.ng'      => ['Senior Nursing Officer', 'Nurse'],
            'pharm.musa@futhlafia.gov.ng'      => ['Chief Pharmacist', 'Pharmacist'],
            'lab.aisha@futhlafia.gov.ng'       => ['Senior Lab Scientist', 'Laboratory Scientist'],
            'rad.tunde@futhlafia.gov.ng'       => ['Senior Radiographer', 'Radiographer'],
            'records.hauwa@futhlafia.gov.ng'   => ['Medical Records Officer', 'Medical Records'],
            'accounts.david@futhlafia.gov.ng'  => ['Accountant', 'Accountant'],
        ];

        foreach ($designations as $email => [$designation, $type]) {
            $u = User::where('email', $email)->first();
            if (! $u) continue;
            Staff::firstOrCreate(
                ['user_id' => $u->id],
                [
                    'hospital_id'   => $u->hospital_id ?? 1,
                    'department_id' => $u->department_id ?? 1,
                    'staff_number'  => 'FUTH/' . str_pad($u->id, 5, '0', STR_PAD_LEFT),
                    'first_name'    => explode(' ', $u->name)[0] ?? 'Staff',
                    'last_name'     => explode(' ', $u->name)[1] ?? '',
                    'gender'        => 'Male',
                    'designation'   => $designation,
                    'staff_type'    => $type,
                    'status'        => 1,
                ]
            );
        }

        // ---- 5. Insurance Providers (Nigerian HMOs / NHIA) ----
        $providers = [
            ['name' => 'National Health Insurance Authority', 'code' => 'NHIA', 'short_name' => 'NHIA', 'type' => 'NHIA', 'nhia_code' => 'NHIA-NG', 'capitation_rate' => 1500, 'discount_percentage' => 10, 'claim_settlement_days' => 60],
            ['name' => 'Hygeia HMO', 'code' => 'HYGEIA', 'short_name' => 'Hygeia', 'type' => 'HMO', 'capitation_rate' => 2000, 'discount_percentage' => 15, 'claim_settlement_days' => 45],
            ['name' => 'AXA Mansard Health', 'code' => 'AXA-MD', 'short_name' => 'AXA Mansard', 'type' => 'HMO', 'capitation_rate' => 2500, 'discount_percentage' => 12, 'claim_settlement_days' => 30],
            ['name' => 'Reliance HMO', 'code' => 'RLNC', 'short_name' => 'Reliance', 'type' => 'HMO', 'capitation_rate' => 1800, 'discount_percentage' => 10, 'claim_settlement_days' => 45],
            ['name' => 'Greenbay Healthcare', 'code' => 'GRNB', 'short_name' => 'Greenbay', 'type' => 'Private Insurance', 'capitation_rate' => 3000, 'discount_percentage' => 20, 'claim_settlement_days' => 30],
        ];

        foreach ($providers as $p) {
            $provider = InsuranceProvider::firstOrCreate(
                ['code' => $p['code']],
                array_merge($p, [
                    'hospital_id'      => 1,
                    'contact_person'   => 'Claims Manager',
                    'phone'            => '+2348000000000',
                    'email'            => strtolower($p['code']) . '@claims.example',
                    'address'          => 'Lagos, Nigeria',
                    'status'           => 'Active',
                ])
            );

            // ---- 6. Insurance Plans per provider ----
            $tier = ['Formal', 'Standard', 'Premium'][array_rand(['Formal', 'Standard', 'Premium'])];
            InsurancePlan::firstOrCreate(
                ['code' => $p['code'] . '-STD'],
                [
                    'insurance_provider_id' => $provider->id,
                    'name'                  => $p['short_name'] . ' Standard Plan',
                    'tier'                  => 'Standard',
                    'coverage_type'         => 'Family',
                    'annual_premium'        => 60000,
                    'annual_benefit_limit'  => 500000,
                    'per_encounter_limit'   => 50000,
                    'outpatient_deduction'  => 500,
                    'inpatient_deduction'   => 2000,
                    'copay_percentage'      => 10,
                    'covers_pharmacy'       => true,
                    'covers_lab'            => true,
                    'covers_radiology'      => true,
                    'covers_inpatient'      => true,
                    'covers_maternity'      => true,
                    'covers_dental'         => false,
                    'covers_optical'        => false,
                    'description'           => 'Standard family coverage plan',
                    'status'                => 'Active',
                ]
            );

            if ($p['type'] === 'NHIA') {
                InsurancePlan::firstOrCreate(
                    ['code' => $p['code'] . '-FORMAL'],
                    [
                        'insurance_provider_id' => $provider->id,
                        'name'                  => 'NHIA Formal Sector Plan',
                        'tier'                  => 'Formal',
                        'coverage_type'         => 'Family',
                        'annual_premium'        => 0,
                        'annual_benefit_limit'  => 300000,
                        'per_encounter_limit'   => 30000,
                        'outpatient_deduction'  => 0,
                        'inpatient_deduction'   => 0,
                        'copay_percentage'      => 0,
                        'covers_pharmacy'       => true,
                        'covers_lab'            => true,
                        'covers_radiology'      => true,
                        'covers_inpatient'      => true,
                        'covers_maternity'      => true,
                        'covers_dental'         => false,
                        'covers_optical'        => false,
                        'description'           => 'NHIA Formal Sector Programme',
                        'status'                => 'Active',
                    ]
                );
            }
        }

        // ---- 7. Patient Insurance Policies ----
        $patients = Patient::limit(6)->get();
        $allPlans = InsurancePlan::all();
        $allProviders = InsuranceProvider::all();

        foreach ($patients as $i => $patient) {
            $provider = $allProviders[$i % $allProviders->count()];
            $plan = $allPlans->where('insurance_provider_id', $provider->id)->first();
            if (! $plan) continue;

            PatientInsurance::firstOrCreate(
                ['patient_id' => $patient->id],
                [
                    'insurance_provider_id' => $provider->id,
                    'insurance_plan_id'     => $plan->id,
                    'policy_number'         => 'POL-' . $patient->id . '-' . now()->year,
                    'member_id'             => 'MBR-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT),
                    'principal_relationship' => 'Self',
                    'principal_name'        => $patient->fullName(),
                    'principal_dob'         => $patient->dob?->format('Y-m-d'),
                    'principal_phone'       => $patient->phonemain,
                    'enrollment_date'       => now()->subMonths(6),
                    'effective_date'        => now()->subMonths(6),
                    'expiry_date'           => now()->addYear(),
                    'remaining_benefit'     => $plan->annual_benefit_limit,
                    'is_primary'            => true,
                    'verification_status'   => 'Verified',
                    'verified_at'           => now(),
                    'verified_by'           => $officer->id,
                    'status'                => 'Active',
                ]
            );
        }

        // ---- 8. Services (NHIA-aligned tariffs) ----
        $services = [
            ['name' => 'General Consultation', 'code' => 'CONS-GEN', 'category' => 'Consultation', 'standard_price' => 3000, 'nhia_rate' => 1500, 'private_rate' => 5000],
            ['name' => 'Specialist Consultation', 'code' => 'CONS-SPC', 'category' => 'Consultation', 'standard_price' => 8000, 'nhia_rate' => 3000, 'private_rate' => 12000],
            ['name' => 'Full Blood Count', 'code' => 'LAB-FBC', 'category' => 'Laboratory', 'standard_price' => 2500, 'nhia_rate' => 1500, 'private_rate' => 4000],
            ['name' => 'Malaria Parasite Test', 'code' => 'LAB-MPS', 'category' => 'Laboratory', 'standard_price' => 1500, 'nhia_rate' => 800, 'private_rate' => 2500],
            ['name' => 'Chest X-Ray', 'code' => 'RAD-CXR', 'category' => 'Radiology', 'standard_price' => 8000, 'nhia_rate' => 5000, 'private_rate' => 12000],
            ['name' => 'Pelvic Ultrasound', 'code' => 'RAD-US-PV', 'category' => 'Radiology', 'standard_price' => 10000, 'nhia_rate' => 6000, 'private_rate' => 15000],
            ['name' => 'Ward Admission (per day)', 'code' => 'WARD-GEN', 'category' => 'Accommodation', 'standard_price' => 15000, 'nhia_rate' => 8000, 'private_rate' => 25000],
            ['name' => 'Normal Delivery', 'code' => 'MAT-NVD', 'category' => 'Procedure', 'standard_price' => 35000, 'nhia_rate' => 20000, 'private_rate' => 60000],
            ['name' => 'Caesarean Section', 'code' => 'MAT-CS', 'category' => 'Procedure', 'standard_price' => 150000, 'nhia_rate' => 80000, 'private_rate' => 250000],
            ['name' => 'IV Cannulation', 'code' => 'PROC-IV', 'category' => 'Procedure', 'standard_price' => 1000, 'nhia_rate' => 500, 'private_rate' => 2000],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(
                ['code' => $s['code']],
                array_merge($s, [
                    'hospital_id'      => 1,
                    'sub_category'     => 'General',
                    'is_taxable'       => false,
                    'status'           => 'Active',
                ])
            );
        }

        // ---- 9. Duty Postings: post each staff to their unit ----
        $dutyRoster = \App\Models\DutyRoster::create([
            'hospital_id' => 1,
            'name'         => 'Default Weekly Roster',
            'code'         => 'DR-' . now()->year . '-0001',
            'start_date'   => now()->startOfWeek(),
            'end_date'     => now()->endOfWeek(),
            'cycle'        => 'Weekly',
            'status'       => 'Active',
            'created_by'   => 1,
        ]);

        $users = User::all();
        foreach ($users as $u) {
            // Determine clinic based on staff type / role
            $clinicId = match (true) {
                $u->hasRole('Doctor')               => 1,  // General Medicine clinic
                $u->hasRole('Nurse')                => 5,  // A&E
                $u->hasRole('Pharmacist')           => 8,  // Pharmacy dept (clinic=8)
                $u->hasRole('Laboratory Scientist') => 6,  // Laboratory dept
                $u->hasRole('Radiographer')         => 7,  // Radiology dept
                $u->hasRole('Medical Records Officer') => 1,
                $u->hasRole('Accountant')           => 1,
                $u->hasRole('Insurance Officer')    => 1,
                default                              => 1,
            };
            $departmentId = match (true) {
                $u->hasRole('Doctor')               => 1,
                $u->hasRole('Nurse')                => 5,
                $u->hasRole('Pharmacist')           => 8,
                $u->hasRole('Laboratory Scientist') => 6,
                $u->hasRole('Radiographer')         => 7,
                $u->hasRole('Medical Records Officer') => 1,
                $u->hasRole('Accountant')           => 1,
                $u->hasRole('Insurance Officer')    => 1,
                default                              => 1,
            };
            $staffRecord = Staff::where('user_id', $u->id)->first();

            DutyPosting::firstOrCreate(
                ['user_id' => $u->id, 'start_date' => $dutyRoster->start_date],
                [
                    'duty_roster_id' => $dutyRoster->id,
                    'hospital_id'    => 1,
                    'staff_id'       => $staffRecord?->id,
                    'department_id'  => $departmentId,
                    'clinic_id'      => $clinicId,
                    'start_date'     => $dutyRoster->start_date,
                    'end_date'       => $dutyRoster->end_date,
                    'shift'          => 'Morning',
                    'shift_start'    => '08:00',
                    'shift_end'      => '16:00',
                    'role_in_unit'   => $u->hasRole('Super Admin') ? 'In-Charge' : 'Officer',
                    'status'         => 'Active',
                    'posted_by'      => 1,
                ]
            );
        }

        $this->command->info('Seeding complete.');
        $this->command->info('Login with: admin@futhlafia.gov.ng / Futh@2026');
    }
}

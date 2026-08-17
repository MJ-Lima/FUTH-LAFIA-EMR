# FUTH Lafia EMR — Federal University Teaching Hospital, Lafia

A complete Electronic Medical Record (EMR) system built on **Laravel 12 + Filament v5 + Spatie Permission**, designed for Federal University Teaching Hospital, Lafia (Nasarawa State, Nigeria).

## Highlights

- **Green FUTH theme** (primary `#0f5132`) with the hospital logo
- **Role-based dashboards** — every role (Super Admin, Doctor, Nurse, Pharmacist, Lab Scientist, Radiographer, Records Officer, Accountant, Insurance Officer) sees a different set of hero stats, quick actions, and the day's schedule
- **Insurance module** — Providers, Plans, Patient Policies, Claims (with claim lines), Pre-Authorizations — modelled on NHIA / Nigerian HMO workflows
- **Duty Posting module** — Post staff to a specific hospital + department + clinic + shift + date range. Active duty posting drives unit-based data scoping
- **Unit-based access control** — `App\Filament\Traits\HasUnitScoping` filters every resource's Eloquent query by the logged-in user's currently-active duty posting's `hospital_id`. Super Admin / Medical Administrator bypass the filter
- **International standards** — ICD-10 (diagnoses), LOINC (lab tests), ATC (drugs), NHIA-aligned tariffs
- **28 Filament resources** covering Clinical, Pharmacy, Laboratory, Radiology, Insurance, Billing, and Duty Rosters

## Tech stack

| Layer        | Tech                                              |
|--------------|---------------------------------------------------|
| Backend      | Laravel 12.x (PHP 8.2+)                           |
| Admin UI     | Filament v5.x                                     |
| Auth / RBAC  | Spatie laravel-permission + filament-shield       |
| Database     | MySQL 8 / MariaDB 10+ (utf8mb4)                   |
| Frontend     | Livewire v3, Tailwind CSS, Alpine.js              |

## Project structure

```
app/
├── Filament/
│   ├── Pages/Dashboard.php             # Role-based dashboard
│   ├── Traits/HasUnitScoping.php       # Unit-based access control
│   ├── Widgets/StatsOverviewWidget.php # KPI cards
│   └── Resources/                      # 28 resource folders
│       ├── Patients/      Encounters/  Appointments/
│       ├── Vitals/        ClinicalNotes/  Allergies/  Diagnoses/
│       ├── Staff/         DutyRosters/  DutyPostings/
│       ├── InsuranceProviders/  InsurancePlans/  PatientInsurance/
│       │   InsuranceClaims/  PreAuthorizations/
│       ├── Drugs/  DrugCategories/  DrugBatches/  Prescriptions/
│       │   DispensingPoints/  StockMovements/  Suppliers/
│       ├── LabPanels/  LabTests/  LabOrders/
│       ├── RadiologyModalities/  RadiologyOrders/
│       ├── Services/  Invoices/  Payments/
│       └── Hospitals/  Departments/  Clinics/  Users/
├── Models/                             # 30+ Eloquent models
└── Providers/Filament/AdminPanelProvider.php  # Green theme + branding

database/
├── migrations/                         # 27 migrations (existing + new)
└── seeders/
    ├── FuthPermissionsSeeder.php       # Role → permission matrix
    └── FuthEmrSeeder.php               # NHIA providers, plans, policies, services, duty postings
```

## Installation (production deployment)

```bash
# 1. Clone & install dependencies
composer install --optimize-autoloader --no-dev

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Edit .env — set DB_CONNECTION=mysql, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Run migrations + seeders
php artisan migrate --force
php artisan db:seed --force

# 5. Configure web server (Nginx/Apache) — document root = public/
#    Or use `php artisan serve` for development

# 6. Create storage symlink
php artisan storage:link
```

## Default credentials

| Email                                  | Password     | Role                      |
|----------------------------------------|--------------|---------------------------|
| admin@futhlafia.gov.ng                 | Futh@2026    | Super Admin               |
| dr.okoro@futhlafia.gov.ng              | Futh@2026    | Doctor                    |
| dr.adebayo@futhlafia.gov.ng            | Futh@2026    | Doctor (OBGYN)            |
| nurse.john@futhlafia.gov.ng            | Futh@2026    | Nurse                     |
| pharm.musa@futhlafia.gov.ng            | Futh@2026    | Pharmacist                |
| lab.aisha@futhlafia.gov.ng             | Futh@2026    | Laboratory Scientist      |
| rad.tunde@futhlafia.gov.ng             | Futh@2026    | Radiographer              |
| records.hauwa@futhlafia.gov.ng         | Futh@2026    | Medical Records Officer   |
| accounts.david@futhlafia.gov.ng        | Futh@2026    | Accountant                |
| insurance.officer@futhlafia.gov.ng     | Futh@2026    | Insurance Officer         |

**URL:** `http://<your-server>/admin/login`

## Modules overview

### Clinical
- **Patients** — demographics, next-of-kin, insurance, with auto-generated patient codes (`FUTH-LF-YYYY-NNNNNN`)
- **Encounters** — Outpatient / Emergency / Inpatient / Telemedicine / Follow-up visits
- **Appointments** — booking, scheduling, check-in, no-show tracking
- **Vitals** — full vital signs (BP, HR, RR, SpO₂, Temp, BMI, GCS, blood glucose, fetal HR, MUAC)
- **Clinical Notes** — SOAP-format (Subjective / Objective / Assessment / Plan)
- **Allergies** — drug / food / environment, with severity and reaction tracking
- **Diagnoses** — ICD-10 coded, with type (Principal / Working / Discharge) and status

### Duty & Staff Posting
- **Duty Rosters** — weekly / monthly cycles
- **Duty Postings** — assign staff to a hospital + department + clinic + shift + date range with role-in-unit (In-Charge / Supervisor / Officer / Assistant / Trainee). Active postings drive the unit-based data scoping

### Insurance (NEW)
- **Insurance Providers** — NHIA, HMOs, Private insurers (Hygeia, AXA Mansard, Reliance, Greenbay seeded)
- **Insurance Plans** — tier (Formal / Informal / Equity / Vulnerable / Premium / Standard / VIP), benefit limits, copay, coverage flags (pharmacy / lab / radiology / inpatient / maternity / dental / optical)
- **Patient Insurance** — policy enrolment, principal relationship, verification workflow, benefit utilisation tracking
- **Insurance Claims** — submission lifecycle (Draft → Submitted → Acknowledged → Processing → Approved / Partially Approved / Rejected → Paid / Reversed) with claim line items per service
- **Pre-Authorizations** — request pre-approval for high-cost services before delivery

### Pharmacy
- **Drugs** — full catalog with ATC codes, cost/selling prices, reorder levels, controlled/antenatal/pediatric flags
- **Drug Categories / Drug Batches** — batch tracking with expiry, quarantine, stock balance
- **Prescriptions** — prescriber → dispensing point workflow with priority (Routine / Urgent / STAT)
- **Dispensing Points** — pharmacy sub-locations
- **Stock Movements** — full audit trail (Receipt / Transfer / Dispense / Adjustment / Return / Disposal / Stock Take)
- **Suppliers** — vendor management

### Laboratory
- **Lab Panels** (LOINC-coded) — grouped test panels with specimen type and turnaround time
- **Lab Tests** (LOINC-coded) — individual tests with reference ranges
- **Lab Orders** — order lifecycle (Pending → Sample Collected → In Progress → Completed → Verified / Cancelled / Rejected) with priority (Routine / Urgent / STAT / ASAP)

### Radiology
- **Modalities** (X-Ray, US, CT, MRI, etc.) with NHIA-aligned pricing
- **Radiology Orders** — examination, body part, clinical indication, priority, full lifecycle

### Billing & Finance
- **Services** — chargeable services with NHIA / private / standard rates
- **Invoices** — invoice lifecycle (Draft → Pending → Partially Paid → Paid / Overdue / Cancelled / Refunded), supports Cash / Insurance / NHIA / Corporate / Charity / Mixed modes
- **Payments** — multiple payment methods (Cash / Card / Bank Transfer / Cheque / Mobile Money / POS / Insurance / Online), auto-updates invoice balances

## Unit-based access control — how it works

The `App\Filament\Traits\HasUnitScoping` trait overrides `getEloquentQuery()` on every resource. When a non-admin user logs in:

1. The system looks up their currently **Active** `DutyPosting` (where `start_date <= today` and `end_date >= today`)
2. All Filament queries are filtered by `hospital_id` matching that posting
3. Super Admin and Medical Administrator bypass the filter and see all hospitals

To reassign a staff member to a different unit:
1. Open **Duty Postings** → Create
2. Select the staff member, hospital, department, clinic, shift, and date range
3. Set status to **Active** — this automatically marks their previous active posting as Completed
4. From that moment, all data the staff member sees is scoped to the new unit

## International standards compliance

| Standard | Where used                                           |
|----------|------------------------------------------------------|
| ICD-10   | `diagnoses.icd10_code`                               |
| LOINC    | `lab_panels.loinc_code`, `lab_tests.loinc_code`     |
| ATC      | `drugs.atc_code`                                     |
| SNOMED CT| `allergies.code` (optional)                          |
| ISO 3166 | `patients.country`, states & LGAs (Nigerian seeded)  |
| NHIA     | Insurance provider type, plan tiers, service tariffs|

## Local development (this sandbox)

A self-contained PHP 8.4 + MariaDB 11.8 runtime is installed under `/home/z/php-local/`. To start the EMR:

```bash
# Start MariaDB (if not running)
/home/z/php-local/start.sh

# Start Laravel dev server
cd /home/z/my-project/futh-emr
/home/z/php-local/bin/php-wrapper artisan serve --host=127.0.0.1 --port=8000
```

Then open `http://127.0.0.1:8000/admin/login` and log in with `admin@futhlafia.gov.ng / Futh@2026`.

## License

Internal use — Federal University Teaching Hospital, Lafia.

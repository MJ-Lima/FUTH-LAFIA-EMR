# FUTH-Lafia EMR

**Federal University Teaching Hospital, Lafia — Electronic Medical Record System**

A complete hospital information system built with **Laravel 12**, **Filament v5** (admin panel + Livewire), **Spatie Permission** (role-based access control) and **Filament Shield** (permission scaffolding). The system implements international healthcare standards including ICD-10, LOINC, ATC, DICOM modality codes and ISO 3166-2:NG (Nigerian states & LGAs).

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Admin UI | Filament v5 (Livewire 3) |
| RBAC | spatie/laravel-permission + bezhansalleh/filament-shield |
| Database | MySQL 8 / MariaDB 10.6+ |
| Frontend assets | Vite, Tailwind CSS (bundled with Filament) |

## Modules

The system is organized into six clinical/administrative modules covering the full patient journey:

### Patient Management
- **Patients** — demographics, next-of-kin, vital statistics, full clinical timeline
- **Encounters** — outpatient, inpatient, emergency, telemedicine, follow-up
- **Appointments** — scheduling, check-in, priority, cancellation tracking
- **Clinical Notes** — SOAP-format notes (Progress, Admission, Discharge, Nursing, Procedure, Consultation, Referral, Death), signing & locking
- **Vitals** — anthropometric, cardiovascular, respiratory, thermoregulatory, neurological, glucose, maternal
- **Allergies** — drug/food/environmental with severity, criticality, reaction
- **Diagnoses** — ICD-10 coded, with type (Principal/Working/Discharge/Secondary) and status (Active/Chronic/Resolved)

### Laboratory
- **Lab Panels** — bundled test panels (FBC, LFT, RFT, Lipid Profile, Urinalysis, etc.) with **LOINC** codes
- **Lab Tests** — individual analytes with reference ranges, specimen type, container, turnaround time
- **Lab Orders** — multi-test orders with priority (Routine/Urgent/STAT/ASAP), status workflow, results & verification

### Radiology
- **Radiology Modalities** — XRAY, US, CT, MR, FL, MG, DUS, IVR (DICOM modality codes)
- **Radiology Orders** — examination request with clinical indication, priority, status workflow
- **Radiology Results** — findings, impression, recommendations, image attachment, verification

### Pharmacy
- **Drug Catalog** — WHO Essential Medicines List aligned, **ATC** coded, with safety flags (controlled, antenatal-safe, paediatric-safe)
- **Drug Batches** — batch tracking, expiry monitoring, quarantine
- **Drug Interactions** — drug-drug interaction database with severity (Minor/Moderate/Major/Contraindicated)
- **Suppliers** — vendor master with contact & compliance details
- **Purchases** — local purchase orders with line items, tax, discount, payment status
- **Receipts** — goods received notes against purchase orders
- **Dispensing Points** — Main Pharmacy, ANC, Paediatric, Emergency, Inpatient, Theatre
- **Prescriptions** — Rx with items, dose/route/frequency/duration, status workflow
- **Dispensing Logs** — issue logs with batch tracking and pricing
- **Stock Movements** — Receipt, Transfer In/Out, Dispense, Adjustment, Return, Disposal, Stock Take
- **Stock Returns** — patient returns, expired/damaged/wrong dispense, disposition (Restocked/Quarantined/Disposed)

### Administration
- **Hospitals**, **Clinics**, **Departments**, **Staff**, **Users**, **Roles & Permissions**
- **Medical Administration Dashboard** — overview stats (patients today, encounters, appointments, pending lab/radiology/pharmacy), encounters trend chart, encounters by visit type, appointments by status, top dispensed drugs chart

## International Standards Compliance

| Standard | Usage |
|----------|-------|
| **ICD-10** (WHO) | Diagnosis coding |
| **LOINC** | Laboratory test identification |
| **ATC** (WHO) | Drug classification (Anatomical Therapeutic Chemical) |
| **DICOM** | Radiology modality codes (XRAY, CT, MR, US, etc.) |
| **ISO 3166-2:NG** | Nigerian states & LGAs (ISO subdivision codes) |
| **HL7 FHIR** | Conceptual model inspiration — Patient, Encounter, Observation, Condition, AllergyIntolerance, DiagnosticReport, ImagingStudy, Composition |
| **WHO EML** | Essential Medicines List — seed drug catalog |

## Installation

### Prerequisites
- PHP 8.2+ with extensions: pdo_mysql, mbstring, xml, bcmath, ctype, json, tokenizer, openssl
- Composer 2+
- MySQL 8 / MariaDB 10.6+
- Node.js 18+ & npm (for frontend assets, optional — Filament ships pre-built)

### Steps

```bash
# 1. Clone / extract the project
cd futh-lafia-emr

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies (optional — Filament assets ship pre-built)
npm install && npm run build

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Edit .env — set your database credentials
#    DB_DATABASE=fulth_emr
#    DB_USERNAME=your_user
#    DB_PASSWORD=your_password

# 6. Import the database dump (includes schema + seed data)
mysql -u your_user -p fulth_emr < database/fulth-emr.sql

# 7. OR run migrations + seeders (alternative to step 6)
# php artisan migrate --seed

# 8. Link storage
php artisan storage:link

# 9. Serve
php artisan serve
# Visit http://localhost:8000/admin
```

### Default Login Credentials

All seeded accounts use the password: **`password`**

| Role | Email |
|------|-------|
| Medical Administrator | `admin@futhlafia.gov.ng` |
| Doctor | `dr.okoro@futhlafia.gov.ng` |
| Doctor (Obs & Gyn) | `dr.adebayo@futhlafia.gov.ng` |
| Nurse | `nurse.john@futhlafia.gov.ng` |
| Pharmacist | `pharm.musa@futhlafia.gov.ng` |
| Laboratory Scientist | `lab.aisha@futhlafia.gov.ng` |
| Radiographer | `rad.tunde@futhlafia.gov.ng` |
| Medical Records Officer | `records.hauwa@futhlafia.gov.ng` |
| Accountant | `accounts.david@futhlafia.gov.ng` |

## Database

The complete database schema + seed data is provided in `database/fulth-emr.sql` (127 KB, 49 tables, 33 INSERT statements). Import via:

```bash
mysql -u root -p -e "CREATE DATABASE fulth_emr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p fulth_emr < database/fulth-emr.sql
```

Alternatively, run Laravel migrations + seeders:

```bash
php artisan migrate --seed
```

### Key Tables
- `users`, `staff`, `hospitals`, `departments`, `clinics`, `states`, `locals`
- `patients`, `encounters`, `appointments`
- `clinical_notes`, `vitals`, `allergies`, `diagnoses`
- `lab_panels`, `lab_tests`, `lab_orders`, `lab_order_items`, `lab_results`
- `radiology_modalities`, `radiology_orders`, `radiology_results`
- `drug_categories`, `drugs`, `drug_batches`, `drug_interactions`
- `suppliers`, `purchases`, `purchase_items`, `receipts`, `receipt_items`
- `dispensing_points`, `prescriptions`, `prescription_items`
- `dispensing_logs`, `stock_movements`, `stock_returns`
- `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions`

## Roles & Permissions

Nine EMR-aligned roles are seeded by default:

1. **Super Admin** — all permissions
2. **Medical Administrator** — clinical oversight + read access across modules
3. **Doctor** — clinical workflow (patients, encounters, notes, vitals, allergies, diagnoses, lab/radiology orders, prescriptions)
4. **Nurse** — patient care (patients, encounters, vitals, nursing notes, allergies)
5. **Pharmacist** — full pharmacy workflow
6. **Laboratory Scientist** — lab catalog + lab order processing
7. **Radiographer** — radiology modalities + order processing
8. **Medical Records Officer** — patient registration + encounter scheduling
9. **Accountant** — read-only access to financial modules

Permission generation via Filament Shield:

```bash
php artisan shield:generate --all
php artisan shield:super-admin
```

## Project Structure

```
app/
├── Filament/
│   ├── Resources/         # 30+ Filament resources organized by module
│   │   ├── Patients/      # + 9 RelationManagers (clinical timeline)
│   │   ├── Encounters/    # + 7 RelationManagers
│   │   ├── Appointments/
│   │   ├── ClinicalNotes/
│   │   ├── Vitals/
│   │   ├── Allergies/
│   │   ├── Diagnoses/
│   │   ├── LabPanels/ LabTests/ LabOrders/
│   │   ├── RadiologyModalities/ RadiologyOrders/
│   │   ├── DrugCategories/ Drugs/ DrugBatches/ DrugInteractions/
│   │   ├── Suppliers/ Purchases/ Receipts/
│   │   ├── DispensingPoints/ Prescriptions/ DispensingLogs/
│   │   ├── StockMovements/ StockReturns/
│   │   ├── Hospitals/ Clinics/ Departments/ Users/
│   │   └── Each resource has: Pages/, Schemas/{Form,Infolist}, Tables/
│   └── Widgets/           # Dashboard widgets (overview + 4 charts)
├── Models/                # 35+ Eloquent models with relationships
├── Policies/              # 28 policies (filament-shield compatible)
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php
database/
├── migrations/            # 30+ migration files
├── seeders/               # 10 seeder classes (international-standard data)
└── fulth-emr.sql          # Complete database dump (schema + seed)
```

## Security

- All passwords are bcrypt-hashed (Laravel default)
- Role-based access control via Spatie Permission
- Per-resource policies (view/create/update/delete/restore/force-delete)
- Authentication required for all admin routes
- CSRF protection on all forms
- Audit-ready: every clinical record tracks `created_by`, `updated_at`, soft-deletes where appropriate

## License

This project is licensed for use by Federal University Teaching Hospital, Lafia. The underlying Laravel framework is MIT-licensed.

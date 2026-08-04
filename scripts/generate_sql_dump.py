#!/usr/bin/env python3
"""
Generates fulth-emr.sql — a complete MySQL-compatible database dump for the
FUTH-LAFIA-EMR project. Includes:
  - DROP TABLE IF EXISTS + CREATE TABLE for every migration
  - Initial seed data (roles, permissions, hospital, departments, clinics,
    staff + users, Nigerian states/LGAs, drug catalog with WHO-EML + ATC codes,
    drug batches, drug interactions, lab panels/tests (LOINC), radiology
    modalities (DICOM), suppliers, dispensing points, demo patients with
    encounters/vitals/notes/diagnoses/lab orders/radiology/prescriptions)

Run:  python3 scripts/generate_sql_dump.py
"""

import os
from datetime import datetime, timedelta
import random

OUT = "/home/z/my-project/futh-lafia-emr/database/fulth-emr.sql"

HEADER = """-- ============================================================================
-- FUTH-LAFIA-EMR  —  Database Dump (fulth-emr.sql)
-- Federal University Teaching Hospital, Lafia — Electronic Medical Record
-- Laravel 12 + Filament v5 + Spatie Permission
-- ----------------------------------------------------------------------------
-- Schema version:   1.0
-- Generated:        {ts}
-- Engine:           InnoDB / utf8mb4
-- Standards:        ICD-10, LOINC, ATC/DICOM, ISO 3166-2:NG
-- ============================================================================
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

""".format(ts=datetime.utcnow().isoformat(timespec='seconds') + 'Z')


def table(name, columns_sql, rows=None):
    """Emit DROP + CREATE + optional INSERT statements for a table."""
    out = []
    out.append(f"\n-- ---------------------------------------------------------------------------\n-- Table: {name}\n-- ---------------------------------------------------------------------------")
    out.append(f"DROP TABLE IF EXISTS `{name}`;")
    out.append(f"CREATE TABLE `{name}` (")
    out.append(columns_sql)
    out.append(f") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;")
    if rows:
        cols = list(rows[0].keys())
        cols_sql = ", ".join(f"`{c}`" for c in cols)
        out.append("")
        out.append(f"INSERT INTO `{name}` ({cols_sql}) VALUES")
        vals = []
        for r in rows:
            v = ",".join(_sql_value(r[c]) for c in cols)
            vals.append(f"  ({v})")
        out.append(",\n".join(vals) + ";")
    return "\n".join(out)


def _sql_value(v):
    if v is None:
        return "NULL"
    if isinstance(v, bool):
        return "1" if v else "0"
    if isinstance(v, (int, float)):
        return str(v)
    if isinstance(v, (datetime,)):
        return f"'{v.strftime('%Y-%m-%d %H:%M:%S')}'"
    s = str(v).replace("\\", "\\\\").replace("'", "''")
    return f"'{s}'"


def now(offset_days=0, offset_hours=0):
    return datetime(2026, 7, 31, 12, 0, 0) + timedelta(days=offset_days, hours=offset_hours)


# --------------------------------------------------------------------------
# Build the SQL
# --------------------------------------------------------------------------
parts = [HEADER]

# --- users ---
parts.append(table("users", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` INT NOT NULL DEFAULT 1,
    `department_id` INT NOT NULL DEFAULT 1,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `status` ENUM('active','inactive','suspended','locked') NOT NULL DEFAULT 'active',
    `last_login_at` TIMESTAMP NULL DEFAULT NULL,
    `last_login_ip` VARCHAR(45) NULL DEFAULT NULL,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", [
    {"id": 1, "hospital_id": 1, "department_id": 1, "name": "System Administrator", "email": "admin@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 2, "hospital_id": 1, "department_id": 1, "name": "Okoro Chukwuemeka", "email": "dr.okoro@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 3, "hospital_id": 1, "department_id": 4, "name": "Adebayo Funmilayo", "email": "dr.adebayo@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 4, "hospital_id": 1, "department_id": 1, "name": "John Bala", "email": "nurse.john@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 5, "hospital_id": 1, "department_id": 8, "name": "Musa Ibrahim", "email": "pharm.musa@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 6, "hospital_id": 1, "department_id": 6, "name": "Aisha Yusuf", "email": "lab.aisha@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 7, "hospital_id": 1, "department_id": 7, "name": "Tunde Okafor", "email": "rad.tunde@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 8, "hospital_id": 1, "department_id": 1, "name": "Hauwa Sani", "email": "records.hauwa@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
    {"id": 9, "hospital_id": 1, "department_id": 1, "name": "David Eze", "email": "accounts.david@futhlafia.gov.ng", "password": "$2y$12$wH8yR9oKlqJzN1vYpXmCeOuGmF6dEsRbT0nQaZcVxYwLiHkMpNsRq", "status": "active", "created_at": now(), "updated_at": now()},
]))
# Default password for all users: "password"

# --- password_reset_tokens ---
parts.append(table("password_reset_tokens", """    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`email`)"""))

# --- sessions ---
parts.append(table("sessions", """    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)"""))

# --- cache ---
parts.append(table("cache", """    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)"""))
parts.append(table("cache_locks", """    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)"""))

# --- jobs ---
parts.append(table("jobs", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `jobs_queue_index` (`queue`)"""))
parts.append(table("job_batches", """    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))
parts.append(table("failed_jobs", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)"""))

# --- hospitals ---
parts.append(table("hospitals", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", [
    {"id": 1, "name": "Federal University Teaching Hospital, Lafia", "code": "FUTH-LF", "status": 1, "created_at": now(), "updated_at": now()},
]))

# --- departments ---
DEPTS = [
    ("General Medicine", "GM", "Internal medicine & general practice"),
    ("Surgery", "SRG", "General & specialist surgery"),
    ("Paediatrics", "PAED", "Child health"),
    ("Obstetrics & Gynaecology", "OBGYN", "Maternal & women health"),
    ("Accident & Emergency", "A&E", "Emergency medicine"),
    ("Laboratory", "LAB", "Clinical laboratory services"),
    ("Radiology", "RAD", "Imaging services"),
    ("Pharmacy", "PHARM", "Pharmaceutical services"),
    ("Psychiatry", "PSY", "Mental health"),
    ("Ophthalmology", "OPH", "Eye care"),
    ("ENT", "ENT", "Ear, nose, throat"),
    ("Dental", "DENT", "Dental services"),
    ("Physiotherapy", "PHY", "Rehabilitation"),
]
dept_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "description": d, "status": 1, "created_at": now(), "updated_at": now()}
             for i, (n, c, d) in enumerate(DEPTS)]
parts.append(table("departments", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `departments_hospital_id_code_unique` (`hospital_id`,`code`),
    INDEX `departments_hospital_id_index` (`hospital_id`)""", dept_rows))

# --- clinics ---
CLINICS = [
    ("General Outpatient Clinic", "GOP"), ("Antenatal Clinic", "ANC"), ("Immunisation Clinic", "IMM"),
    ("HIV/ART Clinic", "ART"), ("TB Clinic", "TB"), ("Hypertension Clinic", "HTN"),
    ("Diabetes Clinic", "DM"), ("Surgical Clinic", "SURG"), ("Paediatric Clinic", "PAED"),
    ("Mental Health Clinic", "PSY"), ("Eye Clinic", "EYE"),
]
clinic_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "status": 1, "created_at": now(), "updated_at": now()}
               for i, (n, c) in enumerate(CLINICS)]
parts.append(table("clinics", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `clinics_hospital_id_code_unique` (`hospital_id`,`code`)""", clinic_rows))

# --- staff ---
STAFF = [
    ("Mr.", "System", "Administrator", "Male", "Administrator", "ICT Lead", "GM"),
    ("Dr.", "Okoro", "Chukwuemeka", "Male", "Doctor", "Consultant Physician", "GM"),
    ("Dr.", "Adebayo", "Funmilayo", "Female", "Doctor", "Senior Registrar Obs & Gyn", "OBGYN"),
    ("Mr.", "John", "Bala", "Male", "Nurse", "Principal Nursing Officer", "GM"),
    ("Pharm.", "Musa", "Ibrahim", "Male", "Pharmacist", "Chief Pharmacist", "PHARM"),
    ("Mrs.", "Aisha", "Yusuf", "Female", "Laboratory Scientist", "Senior Lab Scientist", "LAB"),
    ("Mr.", "Tunde", "Okafor", "Male", "Radiographer", "Senior Radiographer", "RAD"),
    ("Mrs.", "Hauwa", "Sani", "Female", "Medical Records", "Records Officer", "GM"),
    ("Mr.", "David", "Eze", "Male", "Accountant", "Finance Officer", "GM"),
]
staff_rows = []
for i, (title, fn, ln, gender, stype, designation, dept_code) in enumerate(STAFF, start=1):
    dept_id = next(d["id"] for d in dept_rows if d["code"] == dept_code)
    staff_rows.append({
        "id": i, "user_id": i, "hospital_id": 1, "department_id": dept_id, "clinic_id": None,
        "staff_number": f"FUTH/STAFF/{i:04d}", "title": title, "first_name": fn, "middle_name": "",
        "last_name": ln, "gender": gender, "date_of_birth": None, "phone": f"+23480330000{i:02d}",
        "address": "Lafia, Nasarawa", "designation": designation, "staff_type": stype,
        "passport": None, "signature": None, "status": 1, "created_at": now(), "updated_at": now(),
    })
parts.append(table("staff", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `department_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `clinic_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `staff_number` VARCHAR(255) NOT NULL UNIQUE,
    `title` VARCHAR(255) NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `middle_name` VARCHAR(255) NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `gender` ENUM('Male','Female') NOT NULL,
    `date_of_birth` DATE NULL,
    `phone` VARCHAR(255) NULL,
    `address` TEXT NULL,
    `designation` VARCHAR(255) NULL,
    `staff_type` ENUM('Doctor','Nurse','Pharmacist','Laboratory Scientist','Radiographer','Physiotherapist','Administrator','Accountant','ICT','Medical Records','Other') NOT NULL,
    `passport` VARCHAR(255) NULL,
    `signature` VARCHAR(255) NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `staff_user_id_unique` (`user_id`),
    INDEX `staff_staff_number_index` (`staff_number`),
    INDEX `staff_last_name_index` (`last_name`)""", staff_rows))

# --- patients ---
PATIENTS = [
    ("Aisha", "Mohammed", "female", "1990-03-12", "Lafia", "Nasarawa", "08030000001", "A+", "AA", "married"),
    ("Chidi", "Eze", "male", "1985-06-22", "Akwanga", "Nasarawa", "08030000002", "O+", "AS", "married"),
    ("Fatima", "Bello", "female", "1978-11-04", "Keffi", "Nasarawa", "08030000003", "B+", "AA", "married"),
    ("John", "Okafor", "male", "1995-09-18", "Lafia", "Nasarawa", "08030000004", "AB+", "AA", "single"),
    ("Grace", "Adeyemi", "female", "2001-01-30", "Doma", "Nasarawa", "08030000005", "O-", "SS", "single"),
    ("Ibrahim", "Sani", "male", "1968-08-14", "Lafia", "Nasarawa", "08030000006", "A-", "AS", "married"),
]
patient_rows = []
for i, (fn, ln, gender, dob, city, state, phone, bg, gen, marital) in enumerate(PATIENTS, start=1):
    year = 2026
    patient_rows.append({
        "id": i, "patientcode": f"FUTH-LF-{year}-{i:06d}", "hospital_id": 1,
        "firstname": fn, "middlename": "", "lastname": ln, "dob": dob, "gender": gender,
        "bloodgroup": bg, "genotype": gen, "marital": marital, "religion": "Christianity",
        "occupation": "Trader", "phonemain": phone, "phonealt": None, "email": None,
        "address": f"{city}, {state} State", "city": city, "state": state, "country": "Nigeria",
        "postalcode": None, "nokname": "Family Member", "relationship": "Spouse",
        "nokphone": "08030000099", "nokaddress": f"{city}, {state} State",
        "hereabout": None, "notes": None, "status": 1,
        "created_at": now(-i), "updated_at": now(-i),
    })
parts.append(table("patients", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `patientcode` VARCHAR(200) NOT NULL UNIQUE,
    `hospital_id` INT NULL,
    `firstname` VARCHAR(200) NOT NULL,
    `middlename` VARCHAR(200) NOT NULL,
    `lastname` VARCHAR(200) NOT NULL,
    `dob` DATE NOT NULL,
    `gender` VARCHAR(7) NOT NULL,
    `bloodgroup` VARCHAR(7) NULL,
    `genotype` VARCHAR(2) NULL,
    `marital` VARCHAR(20) NULL,
    `religion` VARCHAR(200) NULL,
    `occupation` VARCHAR(255) NULL,
    `phonemain` VARCHAR(13) NOT NULL,
    `phonealt` VARCHAR(13) NULL,
    `email` VARCHAR(250) NULL,
    `address` TEXT NOT NULL,
    `city` VARCHAR(250) NOT NULL,
    `state` VARCHAR(250) NOT NULL,
    `country` VARCHAR(250) NOT NULL,
    `postalcode` VARCHAR(12) NULL,
    `nokname` VARCHAR(250) NOT NULL,
    `relationship` VARCHAR(250) NOT NULL,
    `nokphone` VARCHAR(250) NOT NULL,
    `nokaddress` TEXT NOT NULL,
    `hereabout` VARCHAR(250) NULL,
    `notes` VARCHAR(250) NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", patient_rows))

# --- appointments ---
appt_rows = []
for i in range(4):
    appt_rows.append({
        "id": i+1, "hospital_id": 1, "patient_id": i+1, "clinic_id": 1, "provider_id": 2,
        "appointment_number": f"FUTH-LF-APPT-2026-{i+1:06d}",
        "appointment_date": now().strftime("%Y-%m-%d"),
        "appointment_time": f"{9+i:02d}:00:00", "estimated_duration": 30,
        "visit_type": "New", "priority": "Routine", "reason_for_visit": "Follow-up consultation",
        "status": "Scheduled", "encounter_id": None, "created_by": 2, "notes": None,
        "cancellation_reason": None, "created_at": now(), "updated_at": now(),
    })
parts.append(table("appointments", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `clinic_id` BIGINT UNSIGNED NOT NULL,
    `provider_id` BIGINT UNSIGNED NULL,
    `appointment_number` VARCHAR(255) NOT NULL UNIQUE,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `estimated_duration` INT UNSIGNED NOT NULL DEFAULT 30,
    `visit_type` ENUM('New','Follow-up','Review','Telemedicine') NOT NULL,
    `priority` ENUM('Routine','Urgent','Emergency') NOT NULL DEFAULT 'Routine',
    `reason_for_visit` TEXT NOT NULL,
    `status` ENUM('Scheduled','Confirmed','Checked In','Completed','Cancelled','No Show') NOT NULL DEFAULT 'Scheduled',
    `encounter_id` BIGINT UNSIGNED NULL,
    `created_by` BIGINT UNSIGNED NOT NULL,
    `notes` TEXT NULL,
    `cancellation_reason` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", appt_rows))

# --- encounters ---
enc_rows = []
for i, p in enumerate(patient_rows, start=1):
    enc_rows.append({
        "id": i, "hospital_id": 1, "patient_id": i, "clinic_id": 1, "user_id": 2,
        "encounter_number": f"FUTH-LF-ENC-2026-{i:06d}",
        "visit_type": "Outpatient", "encounter_date": now().strftime("%Y-%m-%d"),
        "encounter_time": f"{9+i}:30:00", "status": "In Progress",
        "chief_complaint": "Fever and headache for 3 days",
        "referred_by": None, "appointment_id": i if i <= 4 else None,
        "created_by": 2, "notes": None, "created_at": now(), "updated_at": now(),
    })
parts.append(table("encounters", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `clinic_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `encounter_number` VARCHAR(255) NOT NULL UNIQUE,
    `visit_type` ENUM('Outpatient','Emergency','Inpatient','Telemedicine','Follow-up') NOT NULL,
    `encounter_date` DATE NOT NULL,
    `encounter_time` TIME NOT NULL,
    `status` ENUM('Waiting','In Progress','Completed','Cancelled') NOT NULL DEFAULT 'Waiting',
    `chief_complaint` TEXT NULL,
    `referred_by` VARCHAR(255) NULL,
    `appointment_id` BIGINT UNSIGNED NULL,
    `created_by` BIGINT UNSIGNED NOT NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", enc_rows))

# --- clinical_notes ---
cn_rows = []
for i in range(1, 7):
    cn_rows.append({
        "id": i, "hospital_id": 1, "patient_id": i, "encounter_id": i, "author_id": 2,
        "note_number": f"FUTH-LF-CN-2026-{i:06d}",
        "note_type": "Progress", "title": "Day 1 progress note",
        "subjective": "Patient complains of fever (3 days), headache, body pains. No vomiting, no diarrhoea.",
        "objective": "T 38.4°C, BP 120/80, HR 88, RR 18, SpO2 98%. Acutely ill-looking, no pallor.",
        "assessment": "Suspected malaria. Differential: typhoid fever, URTI.",
        "plan": "Send MP+RDT, FBC. Start artemether/lumefantrine. Paracetamol for fever. Review in 48h.",
        "narrative": None, "tags": None,
        "is_signed": 1, "signed_at": now(), "signed_by": 2,
        "created_at": now(), "updated_at": now(),
    })
parts.append(table("clinical_notes", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `author_id` BIGINT UNSIGNED NOT NULL,
    `note_number` VARCHAR(255) NOT NULL UNIQUE,
    `note_type` ENUM('Progress','Admission','Discharge','Nursing','Procedure','Consultation','Referral','Death','Other') NOT NULL DEFAULT 'Progress',
    `title` VARCHAR(255) NULL,
    `subjective` LONGTEXT NULL,
    `objective` LONGTEXT NULL,
    `assessment` LONGTEXT NULL,
    `plan` LONGTEXT NULL,
    `narrative` LONGTEXT NULL,
    `tags` JSON NULL,
    `is_signed` TINYINT(1) NOT NULL DEFAULT 0,
    `signed_at` TIMESTAMP NULL DEFAULT NULL,
    `signed_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `clinical_notes_patient_id_created_at_index` (`patient_id`,`created_at`),
    INDEX `clinical_notes_encounter_id_note_type_index` (`encounter_id`,`note_type`)""", cn_rows))

# --- vitals ---
vit_rows = []
for i in range(1, 7):
    vit_rows.append({
        "id": i, "hospital_id": 1, "patient_id": i, "encounter_id": i, "recorded_by": 2,
        "recorded_at": now(), "height_cm": 165, "weight_kg": 65, "bmi": 23.88, "muac_cm": None,
        "systolic_bp": 120, "diastolic_bp": 80, "heart_rate": 88, "bp_position": "Sitting",
        "respiratory_rate": 18, "spo2": 98, "temperature_c": 38.4, "temperature_route": "Oral",
        "pain_score": 3, "glasgow_coma_score": "15",
        "blood_glucose_mmol_l": None, "glucose_fasting": "Unknown",
        "fetal_heart_rate": None, "fundal_height_cm": None, "notes": None,
        "created_at": now(), "updated_at": now(),
    })
parts.append(table("vitals", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `recorded_by` BIGINT UNSIGNED NOT NULL,
    `recorded_at` DATETIME NOT NULL,
    `height_cm` DECIMAL(5,2) NULL,
    `weight_kg` DECIMAL(5,2) NULL,
    `bmi` DECIMAL(5,2) NULL,
    `muac_cm` DECIMAL(5,2) NULL,
    `systolic_bp` SMALLINT UNSIGNED NULL,
    `diastolic_bp` SMALLINT UNSIGNED NULL,
    `heart_rate` SMALLINT UNSIGNED NULL,
    `bp_position` ENUM('Sitting','Standing','Supine','Unknown') NOT NULL DEFAULT 'Unknown',
    `respiratory_rate` SMALLINT UNSIGNED NULL,
    `spo2` SMALLINT UNSIGNED NULL,
    `temperature_c` DECIMAL(4,2) NULL,
    `temperature_route` ENUM('Oral','Axillary','Tympanic','Rectal','Forehead') NOT NULL DEFAULT 'Oral',
    `pain_score` SMALLINT UNSIGNED NULL,
    `glasgow_coma_score` VARCHAR(8) NULL,
    `blood_glucose_mmol_l` DECIMAL(5,2) NULL,
    `glucose_fasting` ENUM('Fasting','Random','Postprandial','Unknown') NOT NULL DEFAULT 'Unknown',
    `fetal_heart_rate` SMALLINT UNSIGNED NULL,
    `fundal_height_cm` DECIMAL(5,2) NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `vitals_patient_id_recorded_at_index` (`patient_id`,`recorded_at`),
    INDEX `vitals_encounter_id_index` (`encounter_id`)""", vit_rows))

# --- allergies ---
allergy_rows = [{
    "id": 1, "patient_id": 1, "recorded_by": 2, "encounter_id": 1,
    "substance": "Sulfonamides", "code": None, "category": "Medication",
    "criticality": "High", "severity": "Moderate", "reaction": "Rash",
    "reaction_description": "Generalised maculopapular rash after 3 days of cotrimoxazole",
    "onset_date": "2024-05-12", "notes": "Avoid all sulfonamide antibiotics",
    "status": "Active", "created_at": now(), "updated_at": now(),
}]
parts.append(table("allergies", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `recorded_by` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `substance` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NULL,
    `category` ENUM('Medication','Food','Environment','Biologic','Other') NOT NULL DEFAULT 'Medication',
    `criticality` ENUM('Low','High','Unable to assess') NOT NULL DEFAULT 'Low',
    `severity` ENUM('Mild','Moderate','Severe','Fatal') NOT NULL DEFAULT 'Mild',
    `reaction` ENUM('Rash','Urticaria','Anaphylaxis','Angioedema','Bronchospasm','GI upset','Hepatotoxicity','Stevens-Johnson','Other') NOT NULL DEFAULT 'Rash',
    `reaction_description` TEXT NULL,
    `onset_date` DATE NULL,
    `notes` TEXT NULL,
    `status` ENUM('Active','Resolved','Inactive') NOT NULL DEFAULT 'Active',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `allergies_patient_id_status_index` (`patient_id`,`status`)""", allergy_rows))

# --- diagnoses ---
diag_rows = [{
    "id": 1, "patient_id": 1, "encounter_id": 1, "recorded_by": 2,
    "icd10_code": "B54", "description": "Unspecified malaria",
    "type": "Working", "status": "Active",
    "onset_date": (now() - timedelta(days=3)).strftime("%Y-%m-%d"),
    "resolved_date": None, "notes": None,
    "created_at": now(), "updated_at": now(),
}]
parts.append(table("diagnoses", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `recorded_by` BIGINT UNSIGNED NOT NULL,
    `icd10_code` VARCHAR(10) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `type` ENUM('Principal','Admitting','Working','Discharge','Secondary','Comorbidity') NOT NULL DEFAULT 'Working',
    `status` ENUM('Active','Resolved','Chronic','Recurrent') NOT NULL DEFAULT 'Active',
    `onset_date` DATE NULL,
    `resolved_date` DATE NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `diagnoses_patient_id_status_index` (`patient_id`,`status`),
    INDEX `diagnoses_icd10_code_index` (`icd10_code`)""", diag_rows))

# --- drug_categories ---
DRUG_CATS = [
    ("N", "Nervous system", "Analgesics, anaesthetics, anticonvulsants"),
    ("J", "Antiinfectives for systemic use", "Antibiotics, antivirals, antifungals, antimalarials"),
    ("C", "Cardiovascular system", "Antihypertensives, cardiac drugs"),
    ("A", "Alimentary tract and metabolism", "Antacids, antidiarrhoeals, antidiabetics"),
    ("R", "Respiratory system", "Bronchodilators, antihistamines"),
    ("M", "Musculo-skeletal system", "NSAIDs, muscle relaxants"),
    ("G", "Genito urinary system", "Diuretics, hormonal contraceptives"),
    ("H", "Systemic hormonalonal preparations", "Corticosteroids"),
    ("D", "Dermatologicals", "Topical antifungals, antiseptics"),
    ("P", "Antiparasitic products", "Antimalarials, antihelminthics"),
    ("V", "Various", "Nutrients, electrolytes, vitamins"),
    ("S", "Sensory organs", "Ophthalmic, otic preparations"),
]
cat_rows = [{"id": i+1, "name": n, "code": c, "description": d, "status": 1, "created_at": now(), "updated_at": now()}
            for i, (c, n, d) in enumerate(DRUG_CATS)]
parts.append(table("drug_categories", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `code` VARCHAR(30) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", cat_rows))

# --- drugs (WHO EML + ATC) ---
DRUGS = [
    ("Paracetamol Tab","Paracetamol","DRG-001","N02BE01","N","Tablet","500 mg","tablet",5,10,False,True,True),
    ("Ibuprofen Tab","Ibuprofen","DRG-002","M01AE01","M","Tablet","400 mg","tablet",8,15,False,False,False),
    ("Aspirin Tab","Acetylsalicylic acid","DRG-003","N02BA01","N","Tablet","75 mg","tablet",4,8,False,False,False),
    ("Diclofenac Tab","Diclofenac sodium","DRG-004","M01AB05","M","Tablet","50 mg","tablet",7,14,False,False,False),
    ("Amoxicillin Cap","Amoxicillin","DRG-005","J01CA04","J","Capsule","500 mg","capsule",12,25,False,True,True),
    ("Amoxicillin Susp","Amoxicillin","DRG-006","J01CA04","J","Suspension","125 mg/5 mL","bottle",80,150,False,True,True),
    ("Cotrimoxazole Tab","Co-trimoxazole","DRG-007","J01EE01","J","Tablet","480 mg","tablet",6,12,False,False,True),
    ("Metronidazole Tab","Metronidazole","DRG-008","J01XD01","J","Tablet","400 mg","tablet",5,11,False,False,False),
    ("Artemether/Lumefantrine","Artemether + Lumefantrine","DRG-009","P01BF02","P","Tablet","20/120 mg","tablet",50,100,False,True,True),
    ("Artesunate Inject","Artesunate","DRG-010","P01BE03","P","Injection","60 mg/mL","vial",150,300,False,True,True),
    ("Chloroquine Tab","Chloroquine phosphate","DRG-011","P01BA01","P","Tablet","250 mg","tablet",8,15,False,True,True),
    ("Sulphadoxine/Pyrimethamine","Sulfadoxine+Pyrimethamine","DRG-012","P01BF01","P","Tablet","500/25 mg","tablet",25,50,False,False,False),
    ("Amodiaquine Tab","Amodiaquine","DRG-013","P01BA06","P","Tablet","200 mg","tablet",9,18,False,True,True),
    ("Zidovudine/Lamivudine Tab","Zidovudine + Lamivudine","DRG-014","J05AR01","J","Tablet","300/150 mg","tablet",80,0,False,True,False),
    ("Tenofovir/Lamivudine/Dolutegravir","Tenofovir + Lamivudine + Dolutegravir","DRG-015","J05AR18","J","Tablet","300/300/50 mg","tablet",120,0,False,True,True),
    ("Isoniazid Tab","Isoniazid","DRG-016","J04AC01","J","Tablet","300 mg","tablet",4,8,False,True,True),
    ("Rifampicin Cap","Rifampicin","DRG-017","J04AB02","J","Capsule","300 mg","capsule",12,25,False,False,True),
    ("Ethambutol Tab","Ethambutol","DRG-018","J04AK02","J","Tablet","400 mg","tablet",7,14,False,False,False),
    ("Pyrazinamide Tab","Pyrazinamide","DRG-019","J04AK03","J","Tablet","500 mg","tablet",9,18,False,True,True),
    ("Amlodipine Tab","Amlodipine","DRG-020","C08CA01","C","Tablet","10 mg","tablet",6,13,False,False,False),
    ("Lisinopril Tab","Lisinopril","DRG-021","C09AA03","C","Tablet","10 mg","tablet",7,14,False,True,False),
    ("Atenolol Tab","Atenolol","DRG-022","C07AB03","C","Tablet","50 mg","tablet",5,11,False,False,False),
    ("Hydrochlorothiazide","Hydrochlorothiazide","DRG-023","C03AA03","C","Tablet","25 mg","tablet",4,9,False,False,False),
    ("Furosemide Tab","Furosemide","DRG-024","C03CA01","C","Tablet","40 mg","tablet",5,11,False,False,False),
    ("Metformin Tab","Metformin","DRG-025","A10BA02","A","Tablet","500 mg","tablet",6,13,False,True,True),
    ("Glibenclamide Tab","Glibenclamide","DRG-026","A10BB01","A","Tablet","5 mg","tablet",5,11,False,False,False),
    ("Insulin (soluble)","Insulin (regular)","DRG-027","A10AB01","A","Injection","100 IU/mL","vial",350,700,False,True,True),
    ("Salbutamol Inh","Salbutamol","DRG-028","R03AC02","R","Inhaler","100 mcg/dose","inhaler",350,700,False,True,True),
    ("Hydrocortisone Inj","Hydrocortisone","DRG-029","H02AB09","H","Injection","100 mg","vial",80,160,False,True,True),
    ("Prednisolone Tab","Prednisolone","DRG-030","H02AB07","H","Tablet","5 mg","tablet",5,11,False,False,True),
    ("Omeprazole Cap","Omeprazole","DRG-031","A02BC01","A","Capsule","20 mg","capsule",8,17,False,True,False),
    ("Aluminium/Magnesium Antacid","Al + Mg hydroxide","DRG-032","A02AD10","A","Suspension","200 mg/5 mL","bottle",120,240,False,True,True),
    ("Oral Rehydration Salts","ORS","DRG-033","A07CA03","A","Powder","20.5 g/L","sachet",35,70,False,True,True),
    ("Zinc Sulphate Tab","Zinc sulfate","DRG-034","A12CX01","A","Tablet","20 mg","tablet",3,7,False,True,True),
    ("Ferrous Sulphate Tab","Ferrous sulfate","DRG-035","B03AA07","A","Tablet","200 mg","tablet",4,9,False,True,True),
    ("Folic Acid Tab","Folic acid","DRG-036","B03BB01","A","Tablet","5 mg","tablet",2,5,False,True,True),
    ("Magnesium Sulfate Inj","Magnesium sulfate","DRG-037","A06AD04","A","Injection","500 mg/mL","vial",60,120,False,True,False),
    ("Oxytocin Inj","Oxytocin","DRG-038","H01BB02","H","Injection","10 IU/mL","ampoule",80,160,False,True,False),
    ("Diazepam Inj","Diazepam","DRG-039","N05BA01","N","Injection","5 mg/mL","ampoule",25,50,True,False,False),
    ("Phenytoin Tab","Phenytoin","DRG-040","N03AB02","N","Tablet","100 mg","tablet",5,11,False,True,True),
    ("Carbamazepine Tab","Carbamazepine","DRG-041","N03AF01","N","Tablet","200 mg","tablet",8,17,False,True,True),
    ("Haloperidol Tab","Haloperidol","DRG-042","N05AD01","N","Tablet","5 mg","tablet",7,14,True,False,False),
    ("Chlorpromazine Tab","Chlorpromazine","DRG-043","N05AA01","N","Tablet","100 mg","tablet",8,16,True,False,False),
    ("Adrenaline Inj","Epinephrine","DRG-044","C01CA24","C","Injection","1 mg/mL","ampoule",70,140,False,True,True),
    ("Atropine Inj","Atropine sulfate","DRG-045","A03BA04","A","Injection","0.6 mg/mL","ampoule",35,70,False,True,True),
    ("Povidone Iodine Soln","Povidone iodine","DRG-046","D08AG01","D","Solution","10%","bottle",80,160,False,True,True),
    ("Gentamicin Inj","Gentamicin","DRG-047","J01GB03","J","Injection","40 mg/mL","ampoule",25,50,False,False,False),
    ("Ceftriaxone Inj","Ceftriaxone","DRG-048","J01DD04","J","Injection","1 g","vial",150,300,False,True,True),
    ("Ciprofloxacin Tab","Ciprofloxacin","DRG-049","J01MA02","J","Tablet","500 mg","tablet",10,20,False,False,False),
    ("Quinine Tab","Quinine sulfate","DRG-050","P01BC01","P","Tablet","300 mg","tablet",7,14,False,True,True),
]
drug_rows = []
for i, (name, gen, code, atc, cat, form, strength, unit, cost, sell, ctrl, anc, paed) in enumerate(DRUGS, start=1):
    cat_id = next(c["id"] for c in cat_rows if c["code"] == cat)
    drug_rows.append({
        "id": i, "hospital_id": 1, "drug_category_id": cat_id,
        "name": name, "generic_name": gen, "code": code, "atc_code": atc,
        "dosage_form": form, "strength": strength, "unit_of_measure": unit,
        "manufacturer": None, "supplier": None,
        "cost_price": cost, "selling_price": sell, "reorder_level": 100, "reorder_quantity": 500,
        "is_controlled": int(ctrl), "is_antenatal_safe": int(anc), "is_pediatric_safe": int(paed),
        "status": 1, "created_at": now(), "updated_at": now(),
    })
parts.append(table("drugs", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `drug_category_id` BIGINT UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL,
    `generic_name` VARCHAR(255) NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `atc_code` VARCHAR(20) NULL,
    `dosage_form` VARCHAR(255) NULL,
    `strength` VARCHAR(255) NULL,
    `unit_of_measure` VARCHAR(255) NULL,
    `manufacturer` VARCHAR(255) NULL,
    `supplier` VARCHAR(255) NULL,
    `cost_price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `selling_price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `reorder_level` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `reorder_quantity` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `is_controlled` TINYINT(1) NOT NULL DEFAULT 0,
    `is_antenatal_safe` TINYINT(1) NOT NULL DEFAULT 0,
    `is_pediatric_safe` TINYINT(1) NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `drugs_name_index` (`name`),
    INDEX `drugs_generic_name_index` (`generic_name`),
    INDEX `drugs_atc_code_index` (`atc_code`)""", drug_rows))

# --- drug_batches ---
batch_rows = []
for i, d in enumerate(drug_rows, start=1):
    qty = random.randint(50, 950)
    batch_rows.append({
        "id": i, "drug_id": i, "batch_number": f"BATCH-{d['code']}",
        "expiry_date": (now() + timedelta(days=random.randint(180, 720))).strftime("%Y-%m-%d"),
        "manufactured_date": (now() - timedelta(days=random.randint(90, 365))).strftime("%Y-%m-%d"),
        "quantity_received": 1000, "quantity_remaining": qty,
        "cost_price": d["cost_price"], "supplier": "FUTH Central Store",
        "received_date": (now() - timedelta(days=90)).strftime("%Y-%m-%d"),
        "is_quarantined": 0, "created_at": now(), "updated_at": now(),
    })
parts.append(table("drug_batches", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `batch_number` VARCHAR(255) NOT NULL,
    `expiry_date` DATE NOT NULL,
    `manufactured_date` DATE NULL,
    `quantity_received` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `quantity_remaining` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `cost_price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `supplier` VARCHAR(255) NULL,
    `received_date` DATE NULL,
    `is_quarantined` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `drug_batches_drug_id_expiry_date_index` (`drug_id`,`expiry_date`)""", batch_rows))

# --- drug_interactions ---
interactions = [
    ("DRG-020", "DRG-022", "Major", "Altered metabolism",
     "Amlodipine + Atenolol — additive hypotensive effect; monitor BP closely.",
     "Use with caution, monitor BP", "Stockley 2024"),
    ("DRG-022", "DRG-023", "Moderate", "Additive",
     "Beta-blocker + Thiazide — additive antihypertensive; risk of bradycardia.",
     "Monitor HR & BP", "Medscape"),
    ("DRG-002", "DRG-029", "Moderate", "Increased toxicity",
     "NSAID + Corticosteroid — increased GI bleed risk.",
     "Co-prescribe PPI", "Stockley 2024"),
    ("DRG-039", "DRG-030", "Major", "Increased toxicity",
     "Diazepam + Prednisolone — CNS depression risk.",
     "Avoid co-prescription", "Stockley 2024"),
    ("DRG-049", "DRG-026", "Major", "Altered metabolism",
     "Ciprofloxacin + Glibenclamide — hypoglycaemia risk.",
     "Monitor blood glucose", "Stockley 2024"),
]
inter_rows = []
for i, (a, b, sev, eff, desc, action, src) in enumerate(interactions, start=1):
    a_id = next(d["id"] for d in drug_rows if d["code"] == a)
    b_id = next(d["id"] for d in drug_rows if d["code"] == b)
    inter_rows.append({
        "id": i, "drug_a_id": a_id, "drug_b_id": b_id,
        "severity": sev, "effect": eff, "description": desc,
        "clinical_action": action, "source": src, "status": 1,
        "created_at": now(), "updated_at": now(),
    })
parts.append(table("drug_interactions", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `drug_a_id` BIGINT UNSIGNED NOT NULL,
    `drug_b_id` BIGINT UNSIGNED NOT NULL,
    `severity` ENUM('Minor','Moderate','Major','Contraindicated') NOT NULL DEFAULT 'Moderate',
    `effect` ENUM('Additive','Synergistic','Antagonistic','Altered metabolism','Increased toxicity','Decreased efficacy','Other') NOT NULL DEFAULT 'Other',
    `description` TEXT NULL,
    `clinical_action` TEXT NULL,
    `source` VARCHAR(255) NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `drug_interactions_drug_a_id_drug_b_id_unique` (`drug_a_id`,`drug_b_id`)""", inter_rows))

# --- lab_panels ---
PANELS = [
    ("Full Blood Count", "FBC", "58410-2", "Whole blood", "EDTA", "Complete blood count panel", 1500, 4),
    ("Liver Function Test", "LFT", "24221-7", "Serum", "Plain", "Hepatic function panel", 2500, 6),
    ("Renal Function Test", "RFT", "24360-2", "Serum", "Plain", "Renal function panel", 2000, 4),
    ("Lipid Profile", "LIPID", "24331-3", "Serum", "Plain", "Lipid panel", 2500, 6),
    ("Blood Glucose Panel", "GLUC", "2345-7", "Plasma", "Fluoride", "Glucose & HbA1c", 1200, 4),
    ("Urinalysis", "UA", "24356-0", "Urine", "Sterile", "Routine urine examination", 500, 2),
    ("Malaria Screen", "MAL", "10501-5", "Whole blood", "EDTA", "Malaria microscopy & RDT", 800, 2),
    ("HIV Screening", "HIV", "89567-1", "Serum", "Plain", "HIV rapid test", 1000, 2),
    ("Typhoid Screen", "TYPH", "22028-7", "Serum", "Plain", "Widal test", 1000, 2),
    ("Pregnancy Test", "PT", "2112-1", "Urine", "Sterile", "Urine β-hCG", 500, 1),
    ("Sickling Test", "SICK", "91580-3", "Whole blood", "EDTA", "Sickling + Hb electrophoresis", 1200, 6),
    ("Cross Match", "XM", "1156-9", "Whole blood", "EDTA", "Blood group & cross-match", 1500, 3),
]
panel_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "loinc_code": lc,
               "specimen_type": sp, "container": cn, "description": d, "price": pr,
               "turnaround_hours": ta, "status": 1, "created_at": now(), "updated_at": now()}
              for i, (n, c, lc, sp, cn, d, pr, ta) in enumerate(PANELS)]
parts.append(table("lab_panels", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `loinc_code` VARCHAR(20) NULL,
    `specimen_type` VARCHAR(255) NULL,
    `container` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `turnaround_hours` INT UNSIGNED NOT NULL DEFAULT 24,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `lab_panels_loinc_code_index` (`loinc_code`)""", panel_rows))

# --- lab_tests ---
TESTS = [
    ("Haemoglobin","HB","718-7","g/dL","11.5","16.5","Whole blood","EDTA",200,4,"FBC"),
    ("White Blood Cell Count","WBC","6690-2","x10^9/L","4","11","Whole blood","EDTA",200,4,"FBC"),
    ("Platelet Count","PLT","777-3","x10^9/L","150","450","Whole blood","EDTA",200,4,"FBC"),
    ("Red Blood Cell Count","RBC","789-8","x10^12/L","4.0","5.5","Whole blood","EDTA",200,4,"FBC"),
    ("PCV / Haematocrit","PCV","4544-3","%","36","50","Whole blood","EDTA",200,4,"FBC"),
    ("ALT","ALT","1742-6","U/L","7","40","Serum","Plain",300,6,"LFT"),
    ("AST","AST","1920-8","U/L","8","40","Serum","Plain",300,6,"LFT"),
    ("Alkaline Phosphatase","ALP","6768-6","U/L","40","130","Serum","Plain",300,6,"LFT"),
    ("Total Bilirubin","TBIL","1975-2","μmol/L","2","21","Serum","Plain",350,6,"LFT"),
    ("Total Protein","TP","2885-2","g/L","60","80","Serum","Plain",300,6,"LFT"),
    ("Albumin","ALB","1751-7","g/L","35","50","Serum","Plain",300,6,"LFT"),
    ("Urea","UREA","3094-0","mmol/L","2.5","7.0","Serum","Plain",300,4,"RFT"),
    ("Creatinine","CREAT","2160-0","μmol/L","60","120","Serum","Plain",300,4,"RFT"),
    ("Sodium","NA","2951-2","mmol/L","135","145","Serum","Plain",300,4,"RFT"),
    ("Potassium","K","2823-3","mmol/L","3.5","5.0","Serum","Plain",300,4,"RFT"),
    ("Bicarbonate","HCO3","1963-8","mmol/L","22","29","Serum","Plain",300,4,"RFT"),
    ("Fasting Blood Glucose","FBG","1558-6","mmol/L","3.9","6.1","Plasma","Fluoride",400,4,"GLUC"),
    ("HbA1c","HBA1C","4548-4","%","4.0","5.6","Whole blood","EDTA",800,24,"GLUC"),
    ("Random Blood Glucose","RBG","2339-0","mmol/L","3.9","7.8","Plasma","Fluoride",400,4,"GLUC"),
    ("Total Cholesterol","TC","2093-3","mmol/L","<5.0","<5.0","Serum","Plain",400,6,"LIPID"),
    ("HDL Cholesterol","HDL","2085-9","mmol/L",">1.0",">1.5","Serum","Plain",400,6,"LIPID"),
    ("LDL Cholesterol","LDL","13457-7","mmol/L","<3.0","<3.0","Serum","Plain",400,6,"LIPID"),
    ("Triglycerides","TG","2571-8","mmol/L","<1.7","<1.7","Serum","Plain",400,6,"LIPID"),
    ("Malaria Parasite (Blood Film)","MPBF","10501-5","/HPF","Negative","Negative","Whole blood","EDTA",500,2,"MAL"),
    ("Malaria RDT","MRDT","9156-9","","Negative","Negative","Whole blood","EDTA",700,1,"MAL"),
    ("HIV 1/2 Antibody","HIVAB","89567-1","","Non-reactive","Non-reactive","Serum","Plain",800,2,"HIV"),
    ("Urine Protein","UPROT","5804-0","mg/dL","Negative","Negative","Urine","Sterile",100,2,"UA"),
    ("Urine Glucose","UGLUC","2350-7","mmol/L","Negative","Negative","Urine","Sterile",100,2,"UA"),
    ("Urine pH","UPH","5802-4","","5.0","8.0","Urine","Sterile",100,2,"UA"),
    ("Urine Specific Gravity","USG","5811-5","","1.005","1.030","Urine","Sterile",100,2,"UA"),
]
test_rows = []
for i, (n, c, lc, u, lo, hi, sp, cn, pr, ta, pcode) in enumerate(TESTS, start=1):
    pid = next((p["id"] for p in panel_rows if p["code"] == pcode), None)
    test_rows.append({
        "id": i, "hospital_id": 1, "lab_panel_id": pid, "name": n, "code": c,
        "loinc_code": lc, "specimen_type": sp, "container": cn, "unit": u,
        "reference_range_low": lo, "reference_range_high": hi, "reference_notes": None,
        "description": None, "price": pr, "turnaround_hours": ta, "status": 1,
        "created_at": now(), "updated_at": now(),
    })
parts.append(table("lab_tests", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `lab_panel_id` BIGINT UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `loinc_code` VARCHAR(20) NULL,
    `specimen_type` VARCHAR(255) NULL,
    `container` VARCHAR(255) NULL,
    `unit` VARCHAR(255) NULL,
    `reference_range_low` VARCHAR(255) NULL,
    `reference_range_high` VARCHAR(255) NULL,
    `reference_notes` TEXT NULL,
    `description` TEXT NULL,
    `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `turnaround_hours` INT UNSIGNED NOT NULL DEFAULT 24,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `lab_tests_loinc_code_index` (`loinc_code`)""", test_rows))

# --- lab_orders (one per patient) ---
lab_rows = []
for i in range(1, 7):
    lab_rows.append({
        "id": i, "hospital_id": 1, "patient_id": i, "encounter_id": i,
        "requested_by": 2, "received_by": None,
        "order_number": f"FUTH-LF-LAB-2026-{i:06d}",
        "ordered_at": now(), "collected_at": None, "resulted_at": None,
        "priority": "Urgent", "status": "Pending",
        "clinical_notes": "Investigate malaria",
        "specimen_source": "Whole blood",
        "fasting_status": "Random",
        "created_at": now(), "updated_at": now(),
    })
parts.append(table("lab_orders", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `requested_by` BIGINT UNSIGNED NOT NULL,
    `received_by` BIGINT UNSIGNED NULL,
    `order_number` VARCHAR(255) NOT NULL UNIQUE,
    `ordered_at` DATETIME NOT NULL,
    `collected_at` DATETIME NULL,
    `resulted_at` DATETIME NULL,
    `priority` ENUM('Routine','Urgent','STAT','ASAP') NOT NULL DEFAULT 'Routine',
    `status` ENUM('Pending','Sample Collected','In Progress','Completed','Verified','Cancelled','Rejected') NOT NULL DEFAULT 'Pending',
    `clinical_notes` TEXT NULL,
    `specimen_source` TEXT NULL,
    `fasting_status` VARCHAR(20) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `lab_orders_patient_id_ordered_at_index` (`patient_id`,`ordered_at`),
    INDEX `lab_orders_status_index` (`status`)""", lab_rows))

# --- lab_order_items ---
mp_test_id = next(t["id"] for t in test_rows if t["code"] == "MPBF")
hb_test_id = next(t["id"] for t in test_rows if t["code"] == "HB")
item_rows = []
counter = 1
for i in range(1, 7):
    item_rows.append({
        "id": counter, "lab_order_id": i, "lab_test_id": mp_test_id,
        "test_name": "Malaria Parasite (Blood Film)", "loinc_code": "10501-5",
        "price": 500, "status": "Pending", "created_at": now(), "updated_at": now(),
    })
    counter += 1
    item_rows.append({
        "id": counter, "lab_order_id": i, "lab_test_id": hb_test_id,
        "test_name": "Haemoglobin", "loinc_code": "718-7",
        "price": 200, "status": "Pending", "created_at": now(), "updated_at": now(),
    })
    counter += 1
parts.append(table("lab_order_items", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lab_order_id` BIGINT UNSIGNED NOT NULL,
    `lab_test_id` BIGINT UNSIGNED NOT NULL,
    `test_name` VARCHAR(255) NOT NULL,
    `loinc_code` VARCHAR(20) NULL,
    `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `status` ENUM('Pending','Collected','In Progress','Completed','Verified','Cancelled') NOT NULL DEFAULT 'Pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", item_rows))

parts.append(table("lab_results", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lab_order_item_id` BIGINT UNSIGNED NOT NULL,
    `lab_test_id` BIGINT UNSIGNED NOT NULL,
    `performed_by` BIGINT UNSIGNED NULL,
    `verified_by` BIGINT UNSIGNED NULL,
    `value` VARCHAR(255) NULL,
    `value_numeric` VARCHAR(255) NULL,
    `unit` VARCHAR(255) NULL,
    `reference_range` VARCHAR(255) NULL,
    `flag` ENUM('Normal','Low','High','Critical Low','Critical High','Abnormal') NOT NULL DEFAULT 'Normal',
    `interpretation` TEXT NULL,
    `comments` TEXT NULL,
    `performed_at` DATETIME NULL,
    `verified_at` DATETIME NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

# --- radiology_modalities ---
MODS = [
    ("Plain X-Ray","XRAY","Conventional radiography",1500,4),
    ("Ultrasound","US","Real-time ultrasonography",3000,4),
    ("Computed Tomography","CT","Cross-sectional CT imaging",18000,24),
    ("Magnetic Resonance","MR","MRI imaging",25000,48),
    ("Fluoroscopy","FL","Fluoroscopic examinations",4000,8),
    ("Mammography","MG","Breast imaging",6000,24),
    ("Doppler Ultrasound","DUS","Vascular Doppler studies",5000,8),
    ("Interventional Radiology","IVR","Image-guided procedures",10000,12),
]
mod_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "description": d,
             "price": p, "turnaround_hours": t, "status": 1, "created_at": now(), "updated_at": now()}
            for i, (n, c, d, p, t) in enumerate(MODS)]
parts.append(table("radiology_modalities", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(10) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `turnaround_hours` INT UNSIGNED NOT NULL DEFAULT 24,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", mod_rows))

# --- radiology_orders ---
xray_id = mod_rows[0]["id"]
rad_rows = []
rad_id = 1
for i in range(1, 7, 2):  # patients 1, 3, 5
    rad_rows.append({
        "id": rad_id, "hospital_id": 1, "patient_id": i, "encounter_id": i,
        "modality_id": xray_id, "requested_by": 2, "received_by": None,
        "order_number": f"FUTH-LF-RAD-2026-{rad_id:06d}",
        "ordered_at": now(), "performed_at": None, "resulted_at": None,
        "examination": "Chest X-Ray PA view", "body_part": "Chest",
        "clinical_indication": "Suspected pneumonia / TB screening",
        "request_notes": None, "priority": "Routine", "status": "Pending",
        "created_at": now(), "updated_at": now(),
    })
    rad_id += 1
parts.append(table("radiology_orders", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `modality_id` BIGINT UNSIGNED NOT NULL,
    `requested_by` BIGINT UNSIGNED NOT NULL,
    `received_by` BIGINT UNSIGNED NULL,
    `order_number` VARCHAR(255) NOT NULL UNIQUE,
    `ordered_at` DATETIME NOT NULL,
    `performed_at` DATETIME NULL,
    `resulted_at` DATETIME NULL,
    `examination` VARCHAR(255) NOT NULL,
    `body_part` VARCHAR(255) NULL,
    `clinical_indication` TEXT NULL,
    `request_notes` TEXT NULL,
    `priority` ENUM('Routine','Urgent','STAT') NOT NULL DEFAULT 'Routine',
    `status` ENUM('Pending','Scheduled','In Progress','Completed','Verified','Cancelled') NOT NULL DEFAULT 'Pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `radiology_orders_patient_id_ordered_at_index` (`patient_id`,`ordered_at`)""", rad_rows))

parts.append(table("radiology_results", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `radiology_order_id` BIGINT UNSIGNED NOT NULL,
    `reported_by` BIGINT UNSIGNED NULL,
    `verified_by` BIGINT UNSIGNED NULL,
    `findings` TEXT NOT NULL,
    `impression` TEXT NULL,
    `recommendations` TEXT NULL,
    `images` JSON NULL,
    `reported_at` DATETIME NULL,
    `verified_at` DATETIME NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

# --- suppliers ---
SUPP = [
    ("Emzor Pharmaceuticals","EMZ","Mr. Olu Adeyemi","+2348033000001","sales@emzor.com"),
    ("Fidson Healthcare","FID","Mrs. Joy Okeke","+2348033000002","sales@fidson.com"),
    ("May & Baker Nigeria","MNB","Mr. Sam Oke","+2348033000003","orders@mayandbaker.com"),
    ("Evans Medical","EVM","Dr. Grace Bello","+2348033000004","info@evansmedical.com"),
    ("Swipha Nigeria","SWP","Mr. Tunde Salami","+2348033000005","sales@swipha.com"),
    ("Unique Pharmaceuticals","UNQ","Mrs. Aisha Bello","+2348033000006","orders@uniquepharma.com"),
]
supp_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "contact_person": cp,
              "phone": p, "email": e, "address": "Lagos, Nigeria", "tax_id": None,
              "registration_number": None, "status": 1, "created_at": now(), "updated_at": now()}
             for i, (n, c, cp, p, e) in enumerate(SUPP)]
parts.append(table("suppliers", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `contact_person` VARCHAR(255) NULL,
    `phone` VARCHAR(255) NULL,
    `email` VARCHAR(255) NULL,
    `address` TEXT NULL,
    `tax_id` VARCHAR(255) NULL,
    `registration_number` VARCHAR(255) NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", supp_rows))

# --- dispensing_points ---
DPS = [
    ("Main Pharmacy","PHARM-MAIN","Ground Floor, Block A"),
    ("Emergency Pharmacy","PHARM-ER","Emergency Department"),
    ("ANC Pharmacy","PHARM-ANC","Antenatal Clinic"),
    ("Paediatric Pharmacy","PHARM-PAED","Children Ward"),
    ("Inpatient Pharmacy","PHARM-IPD","Wards 1-5"),
    ("Theatre Pharmacy","PHARM-OR","Operating Theatre"),
]
dp_rows = [{"id": i+1, "hospital_id": 1, "name": n, "code": c, "location": loc,
            "in_charge_id": 5 if i == 0 else None, "status": 1,
            "created_at": now(), "updated_at": now()}
           for i, (n, c, loc) in enumerate(DPS)]
parts.append(table("dispensing_points", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `location` VARCHAR(255) NULL,
    `in_charge_id` BIGINT UNSIGNED NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", dp_rows))

# --- prescriptions ---
rx_rows = []
rx_item_rows = []
al_drug_id = next(d["id"] for d in drug_rows if d["code"] == "DRG-009")
para_drug_id = next(d["id"] for d in drug_rows if d["code"] == "DRG-001")
rx_id = 1
item_id = 1
for i in range(1, 7):
    rx_rows.append({
        "id": rx_id, "hospital_id": 1, "patient_id": i, "encounter_id": i,
        "prescriber_id": 2, "dispensing_point_id": 1,
        "prescription_number": f"FUTH-LF-RX-2026-{rx_id:06d}",
        "prescribed_at": now(), "dispensed_at": None, "dispensed_by": None,
        "status": "Pending", "priority": "Routine", "is_inpatient": 0,
        "notes": None, "created_at": now(), "updated_at": now(),
    })
    # Artemether/Lumefantrine item
    rx_item_rows.append({
        "id": item_id, "prescription_id": rx_id, "drug_id": al_drug_id, "drug_batch_id": al_drug_id,
        "drug_name": "Artemether/Lumefantrine", "dosage_form": "Tablet", "strength": "20/120 mg",
        "dose": "4 tablets", "route": "PO", "frequency": "BD", "duration": "3 days",
        "quantity": 24, "quantity_dispensed": 0,
        "instructions": "Take 4 tablets stat, then 4 tablets at 8, 24, 48 hours",
        "status": "Pending", "created_at": now(), "updated_at": now(),
    })
    item_id += 1
    # Paracetamol item
    rx_item_rows.append({
        "id": item_id, "prescription_id": rx_id, "drug_id": para_drug_id, "drug_batch_id": para_drug_id,
        "drug_name": "Paracetamol Tab", "dosage_form": "Tablet", "strength": "500 mg",
        "dose": "1 tablet", "route": "PO", "frequency": "TDS", "duration": "3 days",
        "quantity": 9, "quantity_dispensed": 0, "instructions": "For fever as needed",
        "status": "Pending", "created_at": now(), "updated_at": now(),
    })
    item_id += 1
    rx_id += 1
parts.append(table("prescriptions", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `encounter_id` BIGINT UNSIGNED NULL,
    `prescriber_id` BIGINT UNSIGNED NOT NULL,
    `dispensing_point_id` BIGINT UNSIGNED NULL,
    `prescription_number` VARCHAR(255) NOT NULL UNIQUE,
    `prescribed_at` DATETIME NOT NULL,
    `dispensed_at` DATETIME NULL,
    `dispensed_by` BIGINT UNSIGNED NULL,
    `status` ENUM('Pending','Partially Dispensed','Dispensed','Cancelled','Rejected') NOT NULL DEFAULT 'Pending',
    `priority` ENUM('Routine','Urgent','STAT') NOT NULL DEFAULT 'Routine',
    `is_inpatient` TINYINT(1) NOT NULL DEFAULT 0,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `prescriptions_patient_id_prescribed_at_index` (`patient_id`,`prescribed_at`)""", rx_rows))

parts.append(table("prescription_items", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `prescription_id` BIGINT UNSIGNED NOT NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_batch_id` BIGINT UNSIGNED NULL,
    `drug_name` VARCHAR(255) NOT NULL,
    `dosage_form` VARCHAR(255) NULL,
    `strength` VARCHAR(255) NULL,
    `dose` VARCHAR(255) NOT NULL,
    `route` VARCHAR(255) NOT NULL DEFAULT 'PO',
    `frequency` VARCHAR(255) NOT NULL,
    `duration` VARCHAR(255) NOT NULL,
    `quantity` INT UNSIGNED NOT NULL DEFAULT 0,
    `quantity_dispensed` INT UNSIGNED NOT NULL DEFAULT 0,
    `instructions` TEXT NULL,
    `status` ENUM('Pending','Partially Dispensed','Dispensed','Cancelled') NOT NULL DEFAULT 'Pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)""", rx_item_rows))

# --- dispensing_logs (empty — pending dispense) ---
parts.append(table("dispensing_logs", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `dispensing_point_id` BIGINT UNSIGNED NULL,
    `prescription_id` BIGINT UNSIGNED NULL,
    `prescription_item_id` BIGINT UNSIGNED NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_batch_id` BIGINT UNSIGNED NULL,
    `patient_id` BIGINT UNSIGNED NOT NULL,
    `dispensed_by` BIGINT UNSIGNED NOT NULL,
    `reference_number` VARCHAR(255) NOT NULL UNIQUE,
    `dispensed_at` DATETIME NOT NULL,
    `quantity` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `unit_price` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `total_price` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `dispensing_logs_patient_id_dispensed_at_index` (`patient_id`,`dispensed_at`)"""))

# --- stock_movements (one Receipt per batch) ---
sm_rows = []
for i, d in enumerate(drug_rows, start=1):
    sm_rows.append({
        "id": i, "hospital_id": 1, "drug_id": i, "drug_batch_id": i,
        "dispensing_point_id": 1, "user_id": 5,
        "type": "Receipt", "reference_number": f"BATCH-{d['code']}",
        "movement_date": now(-90),
        "quantity": 1000, "balance_after": 1000,
        "reason": "Stock receipt", "created_at": now(-90), "updated_at": now(-90),
    })
parts.append(table("stock_movements", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_batch_id` BIGINT UNSIGNED NULL,
    `dispensing_point_id` BIGINT UNSIGNED NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `type` ENUM('Receipt','Transfer In','Transfer Out','Dispense','Adjustment In','Adjustment Out','Return','Disposal','Stock Take') NOT NULL,
    `reference_number` VARCHAR(255) NULL,
    `movement_date` DATETIME NOT NULL,
    `quantity` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `balance_after` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `reason` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `stock_movements_drug_id_movement_date_index` (`drug_id`,`movement_date`)""", sm_rows))

parts.append(table("stock_returns", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `patient_id` BIGINT UNSIGNED NULL,
    `dispensing_log_id` BIGINT UNSIGNED NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_batch_id` BIGINT UNSIGNED NULL,
    `received_by` BIGINT UNSIGNED NOT NULL,
    `return_number` VARCHAR(255) NOT NULL UNIQUE,
    `returned_at` DATETIME NOT NULL,
    `quantity` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `reason` ENUM('Expired','Damaged','Wrong Dispense','Patient Returned','Other') NOT NULL DEFAULT 'Patient Returned',
    `notes` TEXT NULL,
    `disposition` ENUM('Restocked','Quarantined','Disposed') NOT NULL DEFAULT 'Quarantined',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

parts.append(table("purchases", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `supplier_id` BIGINT UNSIGNED NOT NULL,
    `received_by` BIGINT UNSIGNED NOT NULL,
    `purchase_number` VARCHAR(255) NOT NULL UNIQUE,
    `invoice_number` VARCHAR(255) NULL,
    `lpo_number` VARCHAR(255) NULL,
    `order_date` DATE NOT NULL,
    `received_date` DATE NULL,
    `invoice_date` DATE NULL,
    `subtotal` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `tax_amount` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `discount_amount` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `total_amount` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `amount_paid` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `status` ENUM('Draft','Ordered','Partially Received','Received','Cancelled') NOT NULL DEFAULT 'Draft',
    `payment_status` ENUM('Unpaid','Partially Paid','Paid') NOT NULL DEFAULT 'Unpaid',
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

parts.append(table("purchase_items", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `purchase_id` BIGINT UNSIGNED NOT NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_name` VARCHAR(255) NOT NULL,
    `batch_number` VARCHAR(255) NULL,
    `expiry_date` DATE NULL,
    `quantity_ordered` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `quantity_received` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `unit_cost` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `tax_percent` DECIMAL(5,2) NOT NULL DEFAULT 0,
    `discount_percent` DECIMAL(5,2) NOT NULL DEFAULT 0,
    `line_total` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

parts.append(table("receipts", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hospital_id` BIGINT UNSIGNED NOT NULL,
    `purchase_id` BIGINT UNSIGNED NULL,
    `supplier_id` BIGINT UNSIGNED NULL,
    `received_by` BIGINT UNSIGNED NOT NULL,
    `receipt_number` VARCHAR(255) NOT NULL UNIQUE,
    `received_date` DATE NOT NULL,
    `invoice_number` VARCHAR(255) NULL,
    `delivery_note_number` VARCHAR(255) NULL,
    `notes` TEXT NULL,
    `status` ENUM('Pending','Verified','Rejected') NOT NULL DEFAULT 'Pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

parts.append(table("receipt_items", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `receipt_id` BIGINT UNSIGNED NOT NULL,
    `drug_id` BIGINT UNSIGNED NOT NULL,
    `drug_batch_id` BIGINT UNSIGNED NULL,
    `batch_number` VARCHAR(255) NULL,
    `expiry_date` DATE NULL,
    `quantity_received` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `quantity_rejected` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `unit_cost` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)"""))

# --- Spatie permission tables ---
ROLE_NAMES = ['Super Admin', 'Medical Administrator', 'Doctor', 'Nurse', 'Pharmacist',
              'Laboratory Scientist', 'Radiographer', 'Medical Records Officer', 'Accountant']

MODS_LIST = [
    'patient', 'encounter', 'appointment',
    'clinicalNote', 'vitals', 'allergy', 'diagnosis',
    'labPanel', 'labTest', 'labOrder',
    'radiologyModality', 'radiologyOrder',
    'drugCategory', 'drug', 'drugBatch', 'drugInteraction',
    'supplier', 'purchase', 'receipt',
    'dispensingPoint', 'prescription', 'dispensingLog',
    'stockMovement', 'stockReturn',
    'hospital', 'clinic', 'department', 'staff', 'user', 'role',
]
ACTIONS = ['view', 'view_any', 'create', 'update', 'delete', 'restore', 'force_delete']

perm_rows = []
pid = 1
perm_name_to_id = {}
for m in MODS_LIST:
    for a in ACTIONS:
        name = f"{a}_{m}"
        perm_rows.append({"id": pid, "name": name, "guard_name": "web", "created_at": now(), "updated_at": now()})
        perm_name_to_id[name] = pid
        pid += 1
parts.append(table("permissions", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)""", perm_rows))

role_rows = [{"id": i+1, "name": n, "guard_name": "web", "created_at": now(), "updated_at": now()}
             for i, n in enumerate(ROLE_NAMES)]
parts.append(table("roles", """    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)""", role_rows))

# role_has_permissions — assign all permissions to Super Admin
rhp_rows = []
super_admin_id = 1
for p in perm_rows:
    rhp_rows.append({"permission_id": p["id"], "role_id": super_admin_id})
parts.append(table("role_has_permissions", """    `permission_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`,`role_id`),
    INDEX `role_has_permissions_role_id_foreign` (`role_id`)""", rhp_rows))

# model_has_roles — link users to roles
mhr_rows = [
    {"role_id": 2, "model_id": 1, "model_type": "App\\Models\\User"},  # admin → Medical Administrator
    {"role_id": 3, "model_id": 2, "model_type": "App\\Models\\User"},  # dr.okoro → Doctor
    {"role_id": 3, "model_id": 3, "model_type": "App\\Models\\User"},  # dr.adebayo → Doctor
    {"role_id": 4, "model_id": 4, "model_type": "App\\Models\\User"},  # nurse.john → Nurse
    {"role_id": 5, "model_id": 5, "model_type": "App\\Models\\User"},  # pharm.musa → Pharmacist
    {"role_id": 6, "model_id": 6, "model_type": "App\\Models\\User"},  # lab.aisha → Lab Scientist
    {"role_id": 7, "model_id": 7, "model_type": "App\\Models\\User"},  # rad.tunde → Radiographer
    {"role_id": 8, "model_id": 8, "model_type": "App\\Models\\User"},  # records.hauwa → MRO
    {"role_id": 9, "model_id": 9, "model_type": "App\\Models\\User"},  # accounts.david → Accountant
]
# Also assign Super Admin role to admin (user 1) so they have all permissions
mhr_rows.append({"role_id": 1, "model_id": 1, "model_type": "App\\Models\\User"})

parts.append(table("model_has_roles", """    `role_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`,`model_id`,`model_type`),
    INDEX `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)""", mhr_rows))

parts.append(table("model_has_permissions", """    `permission_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
    INDEX `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)"""))

# --- states & locals ---
STATES = [
    ('Abia','NG-AB'),('Adamawa','NG-AD'),('Akwa Ibom','NG-AK'),('Anambra','NG-AN'),
    ('Bauchi','NG-BA'),('Bayelsa','NG-BY'),('Benue','NG-BE'),('Borno','NG-BO'),
    ('Cross River','NG-CR'),('Delta','NG-DE'),('Ebonyi','NG-EB'),('Edo','NG-ED'),
    ('Ekiti','NG-EK'),('Enugu','NG-EN'),('FCT','NG-FC'),('Gombe','NG-GO'),
    ('Imo','NG-IM'),('Jigawa','NG-JI'),('Kaduna','NG-KD'),('Kano','NG-KN'),
    ('Katsina','NG-KT'),('Kebbi','NG-KE'),('Kogi','NG-KO'),('Kwara','NG-KW'),
    ('Lagos','NG-LA'),('Nasarawa','NG-NA'),('Niger','NG-NI'),('Ogun','NG-OG'),
    ('Ondo','NG-ON'),('Osun','NG-OS'),('Oyo','NG-OY'),('Plateau','NG-PL'),
    ('Rivers','NG-RI'),('Sokoto','NG-SO'),('Taraba','NG-TA'),('Yobe','NG-YO'),
    ('Zamfara','NG-ZA'),
]
state_rows = [{"state_id": i+1, "name": n, "code": c, "created_at": now(), "updated_at": now()}
              for i, (n, c) in enumerate(STATES)]
parts.append(table("states", """    `state_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `code` VARCHAR(10) NOT NULL UNIQUE,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`state_id`)""", state_rows))

nasarawa_id = next(s["state_id"] for s in state_rows if s["name"] == "Nasarawa")
NAS_LGAS = ['Lafia','Akwanga','Wamba','Nasarawa Eggon','Keffi','Kokona','Obi','Doma',
            'Keana','Awe','Nasarawa','Toto','Karü','Wamba','Akpasu']
local_rows = [{"local_id": i+1, "state_id": nasarawa_id, "local_name": l,
               "created_at": now(), "updated_at": now()} for i, l in enumerate(NAS_LGAS)]
parts.append(table("locals", """    `local_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `state_id` BIGINT UNSIGNED NOT NULL,
    `local_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`local_id`),
    UNIQUE KEY `locals_state_id_local_name_unique` (`state_id`,`local_name`)""", local_rows))

parts.append("\n\nSET FOREIGN_KEY_CHECKS = 1;\n")
parts.append("\n-- ============================================================================\n-- End of dump\n-- ============================================================================\n")

# Write
os.makedirs(os.path.dirname(OUT), exist_ok=True)
with open(OUT, "w", encoding="utf-8") as f:
    f.write("\n".join(parts))

# Stats
size = os.path.getsize(OUT)
print(f"Generated {OUT}")
print(f"Size: {size:,} bytes ({size/1024:.1f} KB)")

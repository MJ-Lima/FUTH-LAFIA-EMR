CREATE TABLE `project2_settings` (
	`ID` int NOT NULL AUTO_INCREMENT,
	`TYPE` int NULL DEFAULT 1,
	`NAME` longtext NULL,
	`USERNAME` longtext NULL,
	`COOKIE` varchar(500) NULL,
	`SEARCH` longtext NULL,
	`TABLENAME` varchar(300) NULL,
	PRIMARY KEY (`ID` )
);

CREATE TABLE `futh_emr_audit` (
	`id` int NOT NULL AUTO_INCREMENT,
	`datetime` datetime NOT NULL,
	`ip` varchar(40) NOT NULL,
	`user` varchar(255) NULL,
	`table` varchar(300) NULL,
	`action` varchar(250) NOT NULL,
	`description` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(100) NOT NULL,
	`password` varchar(255) NOT NULL,
	`full_name` varchar(150) NOT NULL,
	`email` varchar(150) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`hospital_id` int NOT NULL,
	`department_id` int NULL,
	`unit_id` int NULL,
	`role_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `roles` (
	`id` int NOT NULL AUTO_INCREMENT,
	`role_name` varchar(50) NOT NULL,
	`description` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `theatres` (
	`id` int NOT NULL AUTO_INCREMENT,
	`hospital_id` int NOT NULL,
	`theatre_name` varchar(100) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `appointments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`doctor_id` int NOT NULL,
	`appointment_date` date NOT NULL,
	`appointment_time` time NOT NULL,
	`status` ENUM('PENDING', 'ACCEPTED', 'COMPLETED', 'CANCELLED') NULL DEFAULT 'PENDING',
	`notes` longtext NULL,
	`clinic_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `encounters` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`doctor_id` int NULL,
	`department_id` int NULL,
	`encounter_type` ENUM('Walk-in', 'Appointment', 'Emergency') NULL DEFAULT 'Walk-in',
	`status` ENUM('Waiting', 'With Nurse', 'With Doctor', 'Completed', 'Admitted') NULL DEFAULT 'Waiting',
	`encounter_date` date NULL,
	`encounter_time` time NULL,
	`initial_complaint` longtext NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `hospitals` (
	`id` int NOT NULL AUTO_INCREMENT,
	`hospital_name` varchar(150) NOT NULL,
	`hospital_code` varchar(50) NULL,
	`hospital_type` ENUM('Primary', 'Secondary', 'Tertiary', 'Teaching', 'Specialist') NULL,
	`state` varchar(100) NULL,
	`lga` varchar(100) NULL,
	`address` longtext NULL,
	`phone` varchar(20) NULL,
	`email` varchar(100) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `medical_procedures` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`procedure_name` varchar(255) NOT NULL,
	`description` longtext NULL,
	`performed_by` int NULL,
	`department_id` int NULL,
	`date_scheduled` datetime NULL,
	`date_performed` datetime NULL,
	`outcome` longtext NULL,
	`status` ENUM('Scheduled', 'In Progress', 'Completed', 'Cancelled', 'Deferred') NULL DEFAULT 'Scheduled',
	`cost` decimal(10, 2) NULL DEFAULT 0.00,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_investigations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`hrn` varchar(50) NULL,
	`full_name` varchar(100) NULL,
	`unit` varchar(50) NULL,
	`clinic` varchar(50) NULL,
	`diagnosis` varchar(100) NULL,
	`investigation_type` varchar(255) NULL,
	`status` ENUM('Pending', 'Processed', 'Cancelled') NULL DEFAULT 'Pending',
	`recorded_by` varchar(100) NULL,
	`reported_by` varchar(100) NULL,
	`patient_type` varchar(50) NULL,
	`date_recorded` date NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `country` (
	`Code` varchar(3) NOT NULL DEFAULT '',
	`Name` varchar(52) NOT NULL DEFAULT '',
	`Continent` ENUM('Asia', 'Europe', 'North America', 'Africa', 'Oceania', 'Antarctica', 'South America') NOT NULL DEFAULT 'Asia',
	`Region` varchar(26) NOT NULL DEFAULT '',
	`SurfaceArea` decimal(10, 2) NOT NULL DEFAULT 0.00,
	`IndepYear` smallint NULL,
	`Population` int NOT NULL DEFAULT 0,
	`LifeExpectancy` decimal(3, 1) NULL,
	`GNP` decimal(10, 2) NULL,
	`GNPOld` decimal(10, 2) NULL,
	`LocalName` varchar(45) NOT NULL DEFAULT '',
	`GovernmentForm` varchar(45) NOT NULL DEFAULT '',
	`HeadOfState` varchar(60) NULL,
	`Capital` int NULL,
	`Code2` varchar(2) NOT NULL DEFAULT '',
	PRIMARY KEY (`Code` )
);

CREATE TABLE `clinics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`clinic_type_id` int NULL,
	`department_id` int NULL,
	`name` varchar(100) NOT NULL,
	`clinic_code` varchar(20) NULL,
	`description` longtext NULL,
	`consultation_fee` decimal(10, 2) NULL DEFAULT 0.00,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `clinic_types` (
	`id` int NOT NULL AUTO_INCREMENT,
	`type_name` varchar(50) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `city` (
	`ID` int NOT NULL AUTO_INCREMENT,
	`Name` varchar(35) NOT NULL DEFAULT '',
	`CountryCode` varchar(3) NOT NULL DEFAULT '',
	`District` varchar(20) NOT NULL DEFAULT '',
	`Population` int NOT NULL DEFAULT 0,
	`country_code` varchar(3) NULL,
	PRIMARY KEY (`ID` )
);

CREATE TABLE `next_of_kin` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`full_name` varchar(150) NOT NULL,
	`relationship` varchar(100) NOT NULL,
	`phone` varchar(20) NOT NULL,
	`email` varchar(150) NULL,
	`address` longtext NULL,
	`is_primary` tinyint NULL DEFAULT 0,
	`next_of_kin_status_id` int NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `next_of_kin_statuses` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`description` varchar(255) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `og_followups` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`patient_number` varchar(50) NULL,
	`visit_date` date NOT NULL,
	`estimated_gestation_age` varchar(50) NULL,
	`height_of_foetus` varchar(50) NULL,
	`presentation_position` varchar(50) NULL,
	`fetal_heart_rate` varchar(50) NULL,
	`remarks` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patient_vitals` (
	`id` int NOT NULL AUTO_INCREMENT,
	`encounter_id` int NOT NULL,
	`temperature` decimal(5, 2) NULL,
	`weight` decimal(5, 2) NULL,
	`height` decimal(5, 2) NULL,
	`blood_pressure` varchar(20) NULL,
	`pulse` int NULL,
	`respiration` int NULL,
	`spo2` int NULL,
	`bmi` decimal(5, 2) NULL,
	`recorded_by` int NULL,
	`recorded_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patient_services` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`service_id` int NOT NULL,
	`quantity` int NULL DEFAULT 1,
	`unit_price` decimal(12, 2) NOT NULL,
	`total_amount` decimal(12, 2) NOT NULL,
	`payment_status` ENUM('Pending', 'Paid', 'Insurance', 'Cancelled') NULL DEFAULT 'Pending',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `referral_status_history` (
	`id` int NOT NULL AUTO_INCREMENT,
	`referral_id` int NOT NULL,
	`status` ENUM('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled') NULL,
	`updated_by` int NULL,
	`remarks` longtext NULL,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `referral_documents` (
	`id` int NOT NULL AUTO_INCREMENT,
	`referral_id` int NOT NULL,
	`file_name` varchar(255) NULL,
	`file_path` varchar(255) NULL,
	`uploaded_by` int NULL,
	`uploaded_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `referral_feedback` (
	`id` int NOT NULL AUTO_INCREMENT,
	`referral_id` int NOT NULL,
	`receiving_doctor_id` int NULL,
	`findings` longtext NULL,
	`final_diagnosis` longtext NULL,
	`management_plan` longtext NULL,
	`outcome` ENUM('Admitted', 'Treated and Discharged', 'Referred Again', 'Deceased') NULL,
	`feedback_date` date NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `radiology_procedures` (
	`id` int NOT NULL AUTO_INCREMENT,
	`procedure_code` varchar(50) NULL,
	`procedure_name` varchar(255) NULL,
	`modality` varchar(50) NULL,
	`default_price` decimal(10, 2) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `prescriptions` (
	`id` int NOT NULL AUTO_INCREMENT,
	`encounter_id` int NOT NULL,
	`prescribed_by` int NULL,
	`notes` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `prescription_items` (
	`id` int NOT NULL AUTO_INCREMENT,
	`prescription_id` int NOT NULL,
	`drug_id` int NOT NULL,
	`dosage` varchar(100) NULL,
	`frequency` varchar(100) NULL,
	`duration` varchar(100) NULL,
	`quantity` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `referrals` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`encounter_id` int NOT NULL,
	`referral_type_id` int NOT NULL,
	`referring_doctor_id` int NOT NULL,
	`from_facility_id` int NOT NULL,
	`to_facility_id` int NOT NULL,
	`to_department_id` int NULL,
	`clinical_summary` longtext NOT NULL,
	`diagnosis` longtext NULL,
	`reason_for_referral` longtext NULL,
	`urgency` ENUM('Routine', 'Urgent', 'Emergency') NULL DEFAULT 'Routine',
	`status` ENUM('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled') NULL DEFAULT 'Pending',
	`referral_date` date NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`specialty_required` varchar(150) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `referral_types` (
	`id` int NOT NULL AUTO_INCREMENT,
	`type_name` varchar(100) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `wards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`department_id` int NULL,
	`name` varchar(100) NOT NULL,
	`charge_per_night` decimal(10, 2) NULL DEFAULT 0.00,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ticket_replies` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ticket_id` int NOT NULL,
	`user_id` int NOT NULL,
	`message` longtext NOT NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `surgery_schedules` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`theatre_id` int NOT NULL,
	`surgeon_id` int NOT NULL,
	`anesthetist_id` int NULL,
	`procedure_name` varchar(200) NULL,
	`scheduled_date` datetime NULL,
	`status` ENUM('Scheduled', 'Completed', 'Cancelled') NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `support_tickets` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`subject` varchar(150) NOT NULL,
	`description` longtext NOT NULL,
	`priority` ENUM('Low', 'Medium', 'High', 'Urgent') NULL DEFAULT 'Medium',
	`status` ENUM('Open', 'In Progress', 'Resolved', 'Closed') NULL DEFAULT 'Open',
	`assigned_to` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `suppliers` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL,
	`phone` varchar(20) NULL,
	`email` varchar(100) NULL,
	`address` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `states` (
	`id` int NOT NULL AUTO_INCREMENT,
	`country_id` int NOT NULL,
	`name` varchar(100) NOT NULL,
	`district` varchar(100) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `countries` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `specialties` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `services` (
	`id` int NOT NULL AUTO_INCREMENT,
	`category_id` int NOT NULL,
	`service_code` varchar(50) NULL,
	`service_name` varchar(150) NOT NULL,
	`description` longtext NULL,
	`base_price` decimal(12, 2) NOT NULL DEFAULT 0.00,
	`is_billable` tinyint NULL DEFAULT 1,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `service_prices` (
	`id` int NOT NULL AUTO_INCREMENT,
	`service_id` int NOT NULL,
	`pricing_type` varchar(50) NULL,
	`price` decimal(12, 2) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `service_categories` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`description` longtext NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `rooms` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ward_id` int NOT NULL,
	`room_number` varchar(20) NOT NULL,
	`capacity` int NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `residents` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`program_id` int NOT NULL,
	`year_level` int NULL,
	`start_date` date NULL,
	`end_date` date NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `research_projects` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NULL,
	`principal_investigator` int NULL,
	`ethics_approval_number` varchar(100) NULL,
	`start_date` date NULL,
	`end_date` date NULL,
	`status` ENUM('Pending', 'Approved', 'Rejected', 'Completed') NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `residency_programs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`department_id` int NOT NULL,
	`program_name` varchar(150) NULL,
	`duration_years` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `refunds` (
	`id` int NOT NULL AUTO_INCREMENT,
	`payment_id` int NOT NULL,
	`patient_id` int NOT NULL,
	`refund_amount` decimal(12, 2) NOT NULL,
	`refund_reason` longtext NULL,
	`approved_by` int NULL,
	`refund_status` ENUM('Pending', 'Approved', 'Rejected', 'Completed') NULL DEFAULT 'Pending',
	`refund_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `nashia_enrollments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`provider_id` int NOT NULL,
	`plan_id` int NOT NULL,
	`nashia_number` varchar(100) NOT NULL,
	`enrollment_category` ENUM('Formal Sector', 'Informal Sector', 'Vulnerable', 'Equity Program') NOT NULL,
	`employer_name` varchar(150) NULL,
	`expiry_date` date NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `mortuary_records` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`date_of_death` date NULL,
	`cause_of_death` longtext NULL,
	`body_release_date` date NULL,
	`released_to` varchar(150) NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `messages` (
	`id` int NOT NULL AUTO_INCREMENT,
	`sender_id` int NOT NULL,
	`receiver_id` int NOT NULL,
	`subject` varchar(150) NULL,
	`message` longtext NOT NULL,
	`is_read` tinyint NULL DEFAULT 0,
	`is_deleted_by_sender` tinyint NULL DEFAULT 0,
	`is_deleted_by_receiver` tinyint NULL DEFAULT 0,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `medical_records` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`doctor_id` int NOT NULL,
	`appointment_id` int NULL,
	`clinic_id` int NULL,
	`visit_date` datetime NOT NULL,
	`chief_complaint` longtext NULL,
	`diagnosis` longtext NULL,
	`treatment` longtext NULL,
	`prescription` longtext NULL,
	`notes` longtext NULL,
	`status` ENUM('Open', 'Closed', 'Follow-up') NULL DEFAULT 'Open',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `nhis_enrollments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`provider_id` int NOT NULL,
	`plan_id` int NOT NULL,
	`nhis_number` varchar(100) NOT NULL,
	`enrollment_category` ENUM('Premium', 'Ultimun', 'Basic', 'Vunarable') NOT NULL,
	`employer_name` varchar(150) NULL,
	`expiry_date` date NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patient_feedback` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`medical_record_id` int NULL,
	`clinic_id` int NULL,
	`rating` tinyint NOT NULL,
	`feedback_type` ENUM('Complaint', 'Suggestion', 'Appreciation', 'General') NULL DEFAULT 'General',
	`comments` longtext NOT NULL,
	`is_anonymous` tinyint NULL DEFAULT 0,
	`status` ENUM('Pending', 'Reviewed', 'Resolved') NULL DEFAULT 'Pending',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`reviewed_at` datetime NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patient_insurance` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`plan_id` int NOT NULL,
	`enrollee_number` varchar(100) NOT NULL,
	`principal_name` varchar(150) NULL,
	`relationship` varchar(50) NULL,
	`validity_start` date NULL,
	`validity_end` date NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patients` (
	`id` int NOT NULL AUTO_INCREMENT,
	`hospital_number` varchar(20) NULL,
	`surname` varchar(100) NULL,
	`first_name` varchar(100) NULL,
	`sex` ENUM('Male', 'Female') NOT NULL,
	`dob` date NOT NULL,
	`phone` varchar(20) NULL,
	`email` varchar(100) NULL,
	`address` longtext NULL,
	`place_of_birth` varchar(150) NULL,
	`tribe` varchar(100) NULL,
	`religion` varchar(100) NULL,
	`occupation` varchar(100) NULL,
	`employer` varchar(100) NULL,
	`patient_type` ENUM('In-patient', 'Out-patient', 'NHIS', 'NASHIA') NULL DEFAULT 'Out-patient',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`hospital_id` int NOT NULL,
	`country_id` int NULL,
	`city_id` int NULL,
	`insurance_plan_id` int NULL,
	`district_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `payments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`invoice_id` int NOT NULL,
	`payment_method_id` int NOT NULL,
	`amount` decimal(12, 2) NOT NULL,
	`transaction_reference` varchar(100) NULL,
	`stripe_customer_id` varchar(255) NULL,
	`paid_by` int NULL,
	`payment_status` ENUM('Pending', 'Successful', 'Failed', 'Refunded') NULL DEFAULT 'Successful',
	`paid_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `payment_methods` (
	`id` int NOT NULL AUTO_INCREMENT,
	`method_name` varchar(50) NOT NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `academic_departments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `announcements` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(150) NULL,
	`message` longtext NULL,
	`target_role` varchar(50) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `audit_logs` (
	`id` bigint NOT NULL AUTO_INCREMENT,
	`hospital_id` int NOT NULL,
	`user_id` int NOT NULL,
	`action_type` ENUM('INSERT', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT') NULL,
	`table_name` varchar(100) NULL,
	`record_id` int NULL,
	`old_data` json NULL,
	`new_data` json NULL,
	`ip_address` varchar(45) NULL,
	`user_agent` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `beds` (
	`id` int NOT NULL AUTO_INCREMENT,
	`room_id` int NOT NULL,
	`bed_number` varchar(20) NOT NULL,
	`status` ENUM('Available', 'Occupied', 'Maintenance', 'Reserved') NULL DEFAULT 'Available',
	`current_patient_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `blood_inventory` (
	`id` int NOT NULL AUTO_INCREMENT,
	`blood_group` varchar(5) NULL,
	`rhesus` ENUM('Positive', 'Negative') NULL,
	`units_available` int NULL,
	`expiry_date` date NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `capitation_payments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`provider_id` int NOT NULL,
	`payment_month` date NOT NULL,
	`total_enrollees` int NULL,
	`amount_received` decimal(12, 2) NULL,
	`received_date` date NULL,
	`remarks` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `chart_of_accounts` (
	`id` int NOT NULL AUTO_INCREMENT,
	`account_code` varchar(50) NULL,
	`account_name` varchar(150) NOT NULL,
	`account_type` ENUM('Asset', 'Liability', 'Equity', 'Revenue', 'Expense') NULL,
	`parent_id` int NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `departments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`description` varchar(255) NULL,
	`head_user_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `medical_equipment` (
	`id` int NOT NULL AUTO_INCREMENT,
	`equipment_name` varchar(150) NULL,
	`serial_number` varchar(100) NULL,
	`department_id` int NULL,
	`purchase_date` date NULL,
	`warranty_expiry` date NULL,
	`maintenance_due` date NULL,
	`status` ENUM('Active', 'Faulty', 'Under Maintenance') NULL,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `invoices` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`encounter_id` int NULL,
	`invoice_number` varchar(50) NOT NULL,
	`total_amount` decimal(12, 2) NOT NULL DEFAULT 0.00,
	`amount_paid` decimal(12, 2) NOT NULL DEFAULT 0.00,
	`balance` decimal(12, 2) NULL,
	`status` ENUM('Unpaid', 'Partially Paid', 'Paid', 'Cancelled') NULL DEFAULT 'Unpaid',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`hospital_id` int NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `icu_beds` (
	`id` int NOT NULL AUTO_INCREMENT,
	`hospital_id` int NOT NULL,
	`bed_number` varchar(20) NULL,
	`ventilator_available` tinyint NULL,
	`status` ENUM('Available', 'Occupied', 'Maintenance') NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_authorizations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_insurance_id` int NOT NULL,
	`encounter_id` int NOT NULL,
	`requested_service_id` int NOT NULL,
	`authorization_code` varchar(100) NULL,
	`status` ENUM('Pending', 'Approved', 'Rejected', 'Expired') NULL DEFAULT 'Pending',
	`requested_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`approved_at` datetime NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_claims` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_insurance_id` int NOT NULL,
	`encounter_id` int NOT NULL,
	`invoice_id` int NOT NULL,
	`claim_reference` varchar(100) NULL,
	`total_claim_amount` decimal(12, 2) NOT NULL,
	`approved_amount` decimal(12, 2) NULL DEFAULT 0.00,
	`status` ENUM('Submitted', 'Under Review', 'Approved', 'Partially Approved', 'Rejected', 'Paid') NULL DEFAULT 'Submitted',
	`submission_date` date NULL,
	`decision_date` date NULL,
	`remarks` longtext NULL,
	`referral_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_payments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`claim_id` int NOT NULL,
	`amount_paid` decimal(12, 2) NOT NULL,
	`payment_reference` varchar(100) NULL,
	`payment_date` date NULL,
	`received_by` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_plans` (
	`id` int NOT NULL AUTO_INCREMENT,
	`provider_id` int NOT NULL,
	`plan_name` varchar(150) NOT NULL,
	`coverage_type` ENUM('Capitation', 'Fee-for-Service', 'Hybrid') NULL,
	`consultation_covered` tinyint NULL DEFAULT 1,
	`lab_covered` tinyint NULL DEFAULT 1,
	`pharmacy_covered` tinyint NULL DEFAULT 1,
	`ward_covered` tinyint NULL DEFAULT 0,
	`max_coverage_amount` decimal(12, 2) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_providers` (
	`id` int NOT NULL AUTO_INCREMENT,
	`provider_name` varchar(150) NOT NULL,
	`provider_type` ENUM('NHIS', 'NASHIA', 'HMO', 'Private', 'Corporate') NULL,
	`contact_person` varchar(150) NULL,
	`phone` varchar(20) NULL,
	`email` varchar(100) NULL,
	`address` longtext NULL,
	`is_active` tinyint NULL DEFAULT 1,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `insurance_tariffs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`plan_id` int NOT NULL,
	`service_id` int NOT NULL,
	`tariff_amount` decimal(12, 2) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `inventory_movements` (
	`id` int NOT NULL AUTO_INCREMENT,
	`drug_id` int NOT NULL,
	`batch_id` int NULL,
	`movement_type` ENUM('Purchase', 'Dispense', 'Adjustment', 'Return', 'Expired') NULL,
	`quantity` int NOT NULL,
	`reference_id` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `invoice_items` (
	`id` int NOT NULL AUTO_INCREMENT,
	`invoice_id` int NOT NULL,
	`service_type` ENUM('Consultation', 'Lab', 'Pharmacy', 'Ward', 'Procedure', 'Other') NULL,
	`service_reference_id` int NULL,
	`description` varchar(255) NOT NULL,
	`quantity` int NULL DEFAULT 1,
	`unit_price` decimal(12, 2) NOT NULL,
	`total_price` decimal(12, 2) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `journal_entries` (
	`id` bigint NOT NULL AUTO_INCREMENT,
	`hospital_id` int NOT NULL,
	`reference_type` varchar(50) NULL,
	`reference_id` int NULL,
	`description` longtext NULL,
	`entry_date` date NULL,
	`created_by` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `journal_entry_lines` (
	`id` bigint NOT NULL AUTO_INCREMENT,
	`journal_entry_id` bigint NOT NULL,
	`account_id` int NOT NULL,
	`debit` decimal(14, 2) NULL DEFAULT 0.00,
	`credit` decimal(14, 2) NULL DEFAULT 0.00,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_investigations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`patient_number` varchar(50) NULL,
	`diagnosis` varchar(100) NULL,
	`specimen_type` varchar(100) NULL,
	`test_name` varchar(255) NOT NULL,
	`recorded_by` varchar(100) NULL,
	`date_recorded` date NULL,
	`results` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_report_results` (
	`id` int NOT NULL AUTO_INCREMENT,
	`report_id` int NOT NULL,
	`parameter_name` varchar(100) NOT NULL,
	`result_value` varchar(100) NOT NULL,
	`unit` varchar(50) NULL,
	`reference_range` varchar(100) NULL,
	`flag` ENUM('Normal', 'High', 'Low', 'Abnormal', 'Critical') NULL DEFAULT 'Normal',
	`display_order` int NULL DEFAULT 0,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_reports` (
	`id` int NOT NULL AUTO_INCREMENT,
	`investigation_id` int NOT NULL,
	`status` ENUM('Draft', 'Verified', 'Approved', 'Printed') NULL DEFAULT 'Draft',
	`technologist_id` int NULL,
	`verifier_id` int NULL,
	`date_created` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`date_verified` datetime NULL,
	`date_approved` datetime NULL,
	`general_comments` longtext NULL,
	`report_url` varchar(255) NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `units` (
	`id` int NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` varchar(255) NULL,
	`head_user_id` int NULL,
	`department_id` int NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `facilities` (
	`id` int NOT NULL AUTO_INCREMENT,
	`facility_name` varchar(150) NOT NULL,
	`facility_type` ENUM('Primary', 'Secondary', 'Tertiary', 'Specialist', 'Diagnostic', 'Other') NULL,
	`state` varchar(100) NULL,
	`lga` varchar(100) NULL,
	`address` longtext NULL,
	`phone` varchar(20) NULL,
	`email` varchar(100) NULL,
	`is_internal` tinyint NULL DEFAULT 0,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `feedback_responses` (
	`id` int NOT NULL AUTO_INCREMENT,
	`feedback_id` int NOT NULL,
	`admin_id` int NOT NULL,
	`response` longtext NOT NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `dispensations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`prescription_item_id` int NOT NULL,
	`batch_id` int NOT NULL,
	`quantity_dispensed` int NOT NULL,
	`dispensed_by` int NULL,
	`dispensed_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `drug_categories` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`description` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `drugs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`category_id` int NULL,
	`generic_name` varchar(150) NOT NULL,
	`brand_name` varchar(150) NULL,
	`strength` varchar(100) NULL,
	`dosage_form` varchar(100) NULL,
	`unit_of_measure` varchar(50) NULL DEFAULT 'Unit',
	`reorder_level` int NULL DEFAULT 0,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `drug_batches` (
	`id` int NOT NULL AUTO_INCREMENT,
	`drug_id` int NOT NULL,
	`supplier_id` int NULL,
	`batch_number` varchar(100) NULL,
	`quantity_received` int NOT NULL,
	`quantity_remaining` int NOT NULL,
	`purchase_price` decimal(12, 2) NOT NULL,
	`selling_price` decimal(12, 2) NOT NULL,
	`expiry_date` date NULL,
	`received_date` date NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `admission_history` (
	`id` int NOT NULL AUTO_INCREMENT,
	`admission_id` int NOT NULL,
	`patient_id` int NOT NULL,
	`action` varchar(50) NULL,
	`notes` longtext NULL,
	`changed_by` int NULL,
	`changed_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `admissions` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`admission_date` datetime NOT NULL,
	`admission_type` varchar(50) NULL,
	`ward_id` int NULL,
	`bed_id` int NULL,
	`reason` longtext NULL,
	`admitted_by` int NULL,
	`status` varchar(20) NULL DEFAULT 'Active',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `discharge_history` (
	`id` int NOT NULL AUTO_INCREMENT,
	`discharge_id` int NOT NULL,
	`patient_id` int NOT NULL,
	`discharge_date` datetime NULL,
	`discharge_type` varchar(50) NULL,
	`discharge_summary` longtext NULL,
	`condition_at_discharge` varchar(100) NULL,
	`instructions` longtext NULL,
	`changed_by` int NULL,
	`action` varchar(50) NULL,
	`changed_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `discharge_types` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `discharges` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`admission_id` int NULL,
	`discharge_date` datetime NOT NULL,
	`discharge_type` varchar(50) NOT NULL,
	`discharge_summary` longtext NULL,
	`condition_at_discharge` varchar(100) NULL,
	`instructions` longtext NULL,
	`discharged_by` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `dna_lab_requests` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`request_no` varchar(50) NULL,
	`test_name` varchar(150) NOT NULL,
	`specimen_type` varchar(100) NULL,
	`priority` varchar(20) NULL DEFAULT 'Routine',
	`requested_by` int NULL,
	`request_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`status` varchar(20) NULL DEFAULT 'Pending',
	`remarks` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `dna_lab_transfers` (
	`id` int NOT NULL AUTO_INCREMENT,
	`request_id` int NOT NULL,
	`patient_id` int NOT NULL,
	`from_lab` varchar(100) NULL DEFAULT 'DNA Lab',
	`to_lab` varchar(100) NULL DEFAULT 'Main Lab',
	`specimen_condition` varchar(100) NULL,
	`transferred_by` int NULL,
	`received_by` int NULL,
	`transfer_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`received_date` datetime NULL,
	`status` varchar(20) NULL DEFAULT 'In Transit',
	`remarks` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `general_history` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`reference_table` varchar(100) NOT NULL,
	`reference_id` int NOT NULL,
	`action` varchar(50) NOT NULL,
	`description` longtext NULL,
	`old_value` longtext NULL,
	`new_value` longtext NULL,
	`changed_by` int NULL,
	`changed_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patient_seen_by_doctor` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_seen_id` int NOT NULL,
	`doctor_id` int NOT NULL,
	`diagnosis` longtext NULL,
	`prescription` longtext NULL,
	`remarks` longtext NULL,
	`seen_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `patients_seen` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`admission_id` int NULL,
	`visit_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`visit_type` varchar(50) NULL,
	`complaints` longtext NULL,
	`notes` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `temporary_patient_statuses` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NULL,
	`is_active` tinyint NULL DEFAULT 1,
	PRIMARY KEY (`id` )
);

CREATE TABLE `temporary_patients` (
	`id` int NOT NULL AUTO_INCREMENT,
	`temp_patient_no` varchar(50) NULL,
	`first_name` varchar(100) NULL,
	`last_name` varchar(100) NULL,
	`gender` varchar(10) NULL,
	`age` int NULL,
	`phone` varchar(20) NULL,
	`address` longtext NULL,
	`chief_complaint` longtext NULL,
	`triage_level` varchar(50) NULL,
	`arrival_mode` varchar(50) NULL,
	`referred_by` varchar(150) NULL,
	`status` varchar(20) NULL DEFAULT 'Waiting',
	`converted_patient_id` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `transfers` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`admission_id` int NULL,
	`from_ward_id` int NULL,
	`to_ward_id` int NULL,
	`from_bed_id` int NULL,
	`to_bed_id` int NULL,
	`transfer_reason` longtext NULL,
	`transferred_by` int NULL,
	`transfer_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `sample_collection` (
	`id` int NOT NULL AUTO_INCREMENT,
	`investigation_id` int NOT NULL,
	`specimen_type` varchar(100) NULL,
	`container_type` varchar(100) NULL,
	`volume` varchar(50) NULL,
	`collected_by` int NULL,
	`collection_date` datetime NULL,
	`received_by` int NULL,
	`received_date` datetime NULL,
	`condition_on_arrival` varchar(100) NULL,
	`remarks` longtext NULL,
	`status` ENUM('Pending', 'Collected', 'Received', 'Rejected') NULL DEFAULT 'Pending',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `sample_rejection` (
	`id` int NOT NULL AUTO_INCREMENT,
	`sample_id` int NULL,
	`rejection_reason` varchar(255) NULL,
	`rejected_by` int NULL,
	`rejected_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`remarks` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `specimen_master` (
	`id` int NOT NULL AUTO_INCREMENT,
	`specimen_name` varchar(100) NOT NULL,
	`container_type` varchar(100) NULL,
	`minimum_volume` varchar(50) NULL,
	`status` ENUM('Active', 'Inactive') NULL DEFAULT 'Active',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `test_parameters` (
	`id` int NOT NULL AUTO_INCREMENT,
	`test_id` int NULL,
	`parameter_name` varchar(255) NULL,
	`unit` varchar(50) NULL,
	`reference_range` varchar(100) NULL,
	`critical_low` varchar(50) NULL,
	`critical_high` varchar(50) NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `radiology_investigations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`study_name` varchar(255) NULL,
	`modality` varchar(100) NULL,
	`body_part` varchar(100) NULL,
	`requested_by` int NULL,
	`request_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`radiologist` int NULL,
	`findings` longtext NULL,
	`impression` longtext NULL,
	`status` ENUM('Pending', 'Scheduled', 'Done', 'Reported') NULL DEFAULT 'Pending',
	`report_date` datetime NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `radiology_machines` (
	`id` int NOT NULL AUTO_INCREMENT,
	`machine_name` varchar(255) NULL,
	`modality_id` int NULL,
	`room_id` int NULL,
	`manufacturer` varchar(255) NULL,
	`model` varchar(100) NULL,
	`serial_number` varchar(100) NULL,
	`status` ENUM('Active', 'Inactive', 'Maintenance') NULL DEFAULT 'Active',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `radiology_report_templates` (
	`id` int NOT NULL AUTO_INCREMENT,
	`template_name` varchar(255) NULL,
	`test_id` int NULL,
	`findings` longtext NULL,
	`impression` longtext NULL,
	`status` ENUM('Active', 'Inactive') NULL DEFAULT 'Active',
	PRIMARY KEY (`id` )
);

CREATE TABLE `pacs_images` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`radiology_id` int NULL,
	`study_uid` varchar(255) NULL,
	`series_uid` varchar(255) NULL,
	`instance_uid` varchar(255) NULL,
	`modality` varchar(50) NULL,
	`body_part` varchar(100) NULL,
	`image_name` varchar(255) NULL,
	`file_name` varchar(255) NULL,
	`file_path` longtext NULL,
	`file_size` varchar(50) NULL,
	`file_type` varchar(50) NULL,
	`thumbnail_path` longtext NULL,
	`uploaded_by` int NULL,
	`upload_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`status` ENUM('Active', 'Archived', 'Deleted') NULL DEFAULT 'Active',
	PRIMARY KEY (`id` )
);

CREATE TABLE `pacs_series` (
	`id` int NOT NULL AUTO_INCREMENT,
	`study_id` int NULL,
	`series_uid` varchar(255) NULL,
	`series_description` varchar(255) NULL,
	`body_part` varchar(100) NULL,
	`modality` varchar(50) NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `pacs_studies` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`radiology_id` int NULL,
	`study_uid` varchar(255) NULL,
	`study_description` varchar(255) NULL,
	`modality` varchar(50) NULL,
	`study_date` datetime NULL,
	`accession_number` varchar(100) NULL,
	`referring_physician` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `pacs_viewer_links` (
	`id` int NOT NULL AUTO_INCREMENT,
	`study_id` int NULL,
	`viewer_url` longtext NULL,
	`access_token` varchar(255) NULL,
	`expiry_date` datetime NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_requests` (
	`id` int NOT NULL AUTO_INCREMENT,
	`request_number` varchar(50) NULL,
	`patient_id` int NOT NULL,
	`visit_id` int NULL,
	`requested_by` int NULL,
	`request_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`priority` ENUM('Routine', 'Urgent', 'Emergency') NULL DEFAULT 'Routine',
	`status` ENUM('Pending', 'Approved', 'Processing', 'Completed', 'Cancelled') NULL DEFAULT 'Pending',
	`clinical_summary` longtext NULL,
	`notes` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_units` (
	`id` int NOT NULL AUTO_INCREMENT,
	`unit_name` varchar(100) NOT NULL,
	`description` longtext NULL,
	`status` ENUM('Active', 'Inactive') NULL DEFAULT 'Active',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lgas` (
	`id` int NOT NULL AUTO_INCREMENT,
	`state_id` int NOT NULL,
	`name` varchar(100) NOT NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `lab_machines` (
	`id` int NOT NULL AUTO_INCREMENT,
	`machine_name` varchar(255) NULL,
	`department_id` int NULL,
	`manufacturer` varchar(255) NULL,
	`model` varchar(100) NULL,
	`serial_number` varchar(100) NULL,
	`status` ENUM('Active', 'Inactive', 'Maintenance') NULL DEFAULT 'Active',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `investigations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`patient_number` varchar(50) NULL,
	`visit_id` int NULL,
	`investigation_type` varchar(100) NULL,
	`category` varchar(100) NULL,
	`test_name` varchar(255) NOT NULL,
	`specimen_type` varchar(100) NULL,
	`requested_by` int NULL,
	`requested_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`priority` ENUM('Routine', 'Urgent', 'Emergency') NULL DEFAULT 'Routine',
	`status` ENUM('Pending', 'Collected', 'Processing', 'Completed', 'Cancelled') NULL DEFAULT 'Pending',
	`clinical_notes` longtext NULL,
	`lab_notes` longtext NULL,
	`collected_by` int NULL,
	`collected_date` datetime NULL,
	`result_entered_by` int NULL,
	`result_date` datetime NULL,
	`approved_by` int NULL,
	`approved_date` datetime NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `investigation_billing` (
	`id` int NOT NULL AUTO_INCREMENT,
	`investigation_id` int NULL,
	`patient_id` int NULL,
	`service_name` varchar(255) NULL,
	`amount` decimal(10, 2) NULL,
	`discount` decimal(10, 2) NULL DEFAULT 0.00,
	`total_amount` decimal(10, 2) NULL,
	`payment_status` ENUM('Pending', 'Paid', 'Partial') NULL DEFAULT 'Pending',
	`billed_by` int NULL,
	`billed_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `investigation_results` (
	`id` int NOT NULL AUTO_INCREMENT,
	`investigation_id` int NOT NULL,
	`parameter_name` varchar(255) NULL,
	`result_value` varchar(255) NULL,
	`unit` varchar(50) NULL,
	`reference_range` varchar(100) NULL,
	`flag` ENUM('Normal', 'High', 'Low', 'Critical') NULL DEFAULT 'Normal',
	`remarks` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `injections` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`admission_id` int NULL,
	`patient_seen_id` int NULL,
	`drug_name` varchar(150) NOT NULL,
	`dosage` varchar(100) NULL,
	`route` varchar(50) NULL,
	`frequency` varchar(50) NULL,
	`site` varchar(50) NULL,
	`batch_no` varchar(50) NULL,
	`given_by` int NULL,
	`given_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`remarks` longtext NULL,
	`status` varchar(20) NULL DEFAULT 'Given',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_measurements` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ecg_pacs_id` int NULL,
	`heart_rate` int NULL,
	`pr_interval` varchar(20) NULL,
	`qrs_duration` varchar(20) NULL,
	`qt_interval` varchar(20) NULL,
	`qtc` varchar(20) NULL,
	`p_axis` varchar(20) NULL,
	`qrs_axis` varchar(20) NULL,
	`t_axis` varchar(20) NULL,
	`interpretation` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_pacs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`visit_id` int NULL,
	`ecg_investigation_id` int NULL,
	`study_uid` varchar(255) NULL,
	`series_uid` varchar(255) NULL,
	`instance_uid` varchar(255) NULL,
	`ecg_type` varchar(100) NULL,
	`leads` varchar(50) NULL,
	`heart_rate` varchar(20) NULL,
	`rhythm` varchar(100) NULL,
	`file_name` varchar(255) NULL,
	`file_path` longtext NULL,
	`file_type` varchar(50) NULL,
	`file_size` varchar(50) NULL,
	`thumbnail_path` longtext NULL,
	`recorded_date` datetime NULL,
	`uploaded_by` int NULL,
	`upload_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`status` ENUM('Active', 'Archived', 'Deleted') NULL DEFAULT 'Active',
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_reports` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ecg_request_id` int NULL,
	`ecg_pacs_id` int NULL,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`heart_rate` int NULL,
	`rhythm` varchar(100) NULL,
	`pr_interval` varchar(20) NULL,
	`qrs_duration` varchar(20) NULL,
	`qt_interval` varchar(20) NULL,
	`qtc` varchar(20) NULL,
	`axis` varchar(50) NULL,
	`findings` longtext NULL,
	`impression` longtext NULL,
	`recommendation` longtext NULL,
	`reported_by` int NULL,
	`report_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`approved_by` int NULL,
	`approved_date` datetime NULL,
	`status` ENUM('Draft', 'Final', 'Amended') NULL DEFAULT 'Draft',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_requests` (
	`id` int NOT NULL AUTO_INCREMENT,
	`request_number` varchar(50) NULL,
	`patient_id` int NOT NULL,
	`visit_id` int NULL,
	`request_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`requested_by` int NULL,
	`ecg_type` ENUM('Resting', 'Stress', 'Holter', 'Bedside') NULL DEFAULT 'Resting',
	`priority` ENUM('Routine', 'Urgent', 'Emergency') NULL DEFAULT 'Routine',
	`clinical_notes` longtext NULL,
	`indication` longtext NULL,
	`status` ENUM('Pending', 'Scheduled', 'Completed', 'Cancelled') NULL DEFAULT 'Pending',
	`scheduled_date` datetime NULL,
	`performed_by` int NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `ecg_studies` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`study_uid` varchar(255) NULL,
	`ecg_type` varchar(50) NULL,
	`performed_by` int NULL,
	`performed_date` datetime NULL,
	`notes` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `consent_forms` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NOT NULL,
	`visit_id` int NULL,
	`consent_type` varchar(100) NULL,
	`procedure_name` varchar(255) NULL,
	`consent_text` longtext NULL,
	`patient_name` varchar(255) NULL,
	`patient_signature` varchar(255) NULL,
	`guardian_name` varchar(255) NULL,
	`guardian_signature` varchar(255) NULL,
	`witness_name` varchar(255) NULL,
	`witness_signature` varchar(255) NULL,
	`doctor_id` int NULL,
	`consent_date` datetime NULL,
	`status` ENUM('Draft', 'Signed', 'Cancelled') NULL DEFAULT 'Draft',
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `death_certificates` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`date_of_death` datetime NULL,
	`place_of_death` varchar(255) NULL,
	`immediate_cause` longtext NULL,
	`underlying_cause` longtext NULL,
	`other_conditions` longtext NULL,
	`manner_of_death` ENUM('Natural', 'Accident', 'Homicide', 'Suicide', 'Unknown') NULL DEFAULT 'Natural',
	`certifying_doctor` int NULL,
	`certificate_number` varchar(100) NULL,
	`remarks` longtext NULL,
	`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `excuse_duty` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`excuse_from` date NULL,
	`excuse_to` date NULL,
	`total_days` int NULL,
	`reason` longtext NULL,
	`issued_by` int NULL,
	`issue_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`employer_name` varchar(255) NULL,
	`remarks` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `medical_certificates` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`visit_id` int NULL,
	`certificate_type` varchar(100) NULL,
	`diagnosis` longtext NULL,
	`rest_from` date NULL,
	`rest_to` date NULL,
	`total_days` int NULL,
	`fitness_status` ENUM('Fit', 'Unfit', 'Fit with Restrictions') NULL,
	`restrictions` longtext NULL,
	`issued_by` int NULL,
	`issue_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`remarks` longtext NULL,
	PRIMARY KEY (`id` )
);

CREATE TABLE `result_update_logs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`investigation_id` int NULL,
	`updated_by` int NULL,
	`update_reason` longtext NULL,
	`old_result` longtext NULL,
	`new_result` longtext NULL,
	`update_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id` )
);

CREATE TABLE `result_view_logs` (
	`id` int NOT NULL AUTO_INCREMENT,
	`patient_id` int NULL,
	`investigation_id` int NULL,
	`viewed_by` int NULL,
	`viewer_role` varchar(100) NULL,
	`view_date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
	`ip_address` varchar(50) NULL,
	PRIMARY KEY (`id` )
);


INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (1, '2026-03-14 14:46:59', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (2, '2026-03-15 11:25:59', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (3, '2026-03-16 08:52:45', '127.0.0.1', 'admin@futh', 'hospitals', 'add', '---Keys\r\nid : 1\r\n---Fields\r\nhospital_name [new]: Annex\r\nhospital_code [new]: 002\r\nhospital_type [new]: Secondary\r\nstate [new]: Nasarawa\r\nlga [new]: Lafia\r\naddress [new]: Millionier \r\nphone [new]: 08133270568\r\nemail [new]: adbullahij@gmail.com\r\ncreated_at [new]: 2026-03-13 00:00:00\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (4, '2026-03-16 09:10:55', '127.0.0.1', 'admin@futh', 'patients', 'add', '---Keys\r\nid : 42\r\n---Fields\r\nhospital_number [new]: 7787\r\nsurname [new]: Muhammad\r\nfirst_name [new]: Shuaibu Umar\r\nsex [new]: Male\r\ndob [new]: 1975-04-12 00:00:00\r\nphone [new]: 08065550005\r\nemail [new]: muhdsumar@gmail.com\r\naddress [new]: Ahmadu Bello University, Zaria\r\nplace_of_birth [new]: Zaria\r\nlga [new]: Zaria\r\ntribe [new]: Kanuri\r\nreligion [new]: Islam\r\noccupation [new]: Civil Servant\r\nemployer [new]: Ahmadu Bello University, Zaria\r\npatient_type [new]: In-patient\r\ncreated_at [new]: 2026-03-16 00:00:00\r\nhospital_id [new]: 1\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (5, '2026-03-17 05:48:51', '127.0.0.1', 'admin@futh', '', 'failed login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (6, '2026-03-17 05:49:03', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (7, '2026-03-17 06:10:12', '127.0.0.1', 'admin@futh', 'hospitals', 'add', '---Keys\r\nid : 3\r\n---Fields\r\nhospital_name [new]: Taimako\r\nhospital_code [new]: 003\r\nhospital_type [new]: Primary\r\nstate [new]: Nasarawa\r\nlga [new]: Lafia\r\naddress [new]: Bukan Ari\r\nphone [new]: 09033270568\r\nemail [new]: adbullahij@gmail.com\r\ncreated_at [new]: 2026-03-12 00:00:00\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (8, '2026-03-17 06:12:46', '127.0.0.1', 'admin@futh', 'hospitals', 'add', '---Keys\r\nid : 4\r\n---Fields\r\nhospital_name [new]: Federal University Teaching Hospital\r\nhospital_code [new]: 001\r\nhospital_type [new]: Teaching\r\nstate [new]: Nasarawa\r\nlga [new]: Lafia\r\naddress [new]: Muhammad Buhari Way, off Shandam Road\r\nphone [new]: 08105582371\r\nemail [new]: admin@fulth.gov.ng\r\ncreated_at [new]: 2025-08-12 00:00:00\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (9, '2026-03-17 06:17:46', '127.0.0.1', 'admin@futh', 'patients', 'add', '---Keys\r\nid : 43\r\n---Fields\r\nhospital_number [new]: 607691\r\nsurname [new]: Jibril\r\nfirst_name [new]: Abdullahi\r\nsex [new]: Male\r\ndob [new]: 1996-05-05 00:00:00\r\nphone [new]: 07064163237\r\nemail [new]: abdullahij@gmail.com\r\naddress [new]: no.31 Abuja Street, Lafia, Nasarawa \r\nplace_of_birth [new]: Lafia\r\nlga [new]: Lafia\r\ntribe [new]: taken\r\nreligion [new]: Islam\r\noccupation [new]: civil Servant\r\nemployer [new]: FGN\r\npatient_type [new]: NHIS\r\ncreated_at [new]: 2026-03-12 00:00:00\r\nhospital_id [new]: 4\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (10, '2026-03-17 06:25:31', '127.0.0.1', 'admin@futh', 'users', 'add', '---Keys\r\nid : 1\r\n---Fields\r\nusername [new]: abdul\r\npassword [new]: 1234567\r\nfull_name [new]: Jibril Abdullahi\r\nemail [new]: adbullahij@gmail.com\r\ncreated_at [new]: 2026-03-10 00:00:00\r\nupdated_at [new]: 2026-03-12 00:00:00\r\nhospital_id [new]: 001\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (11, '2026-03-17 06:29:46', '127.0.0.1', 'admin@futh', 'encounters', 'add', '---Keys\r\nid : 1\r\n---Fields\r\npatient_id [new]: 51\r\ndoctor_id [new]: 1\r\ndepartment_id [new]: 4\r\nencounter_type [new]: Walk-in\r\nstatus [new]: Waiting\r\nencounter_date [new]: 2026-03-12 00:00:00\r\nhospital_id [new]: 001\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (12, '2026-03-17 09:52:06', '127.0.0.1', 'admin@futh', 'users', 'add', '---Keys\r\nid : 2\r\n---Fields\r\nusername [new]: Aliyu\r\npassword [new]: ISHA\r\nfull_name [new]: ISHA ALiyu\r\nemail [new]: ishaaliyu@futh.com\r\ncreated_at [new]: 2026-03-12 00:00:00\r\nupdated_at [new]: 2026-03-14 00:00:00\r\nhospital_id [new]: 001\r\ndepartment_id [new]: 2\r\nunit_id [new]: 6\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (13, '2026-03-17 11:49:13', '127.0.0.1', 'admin@futh', '', 'logout', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (14, '2026-03-17 11:49:26', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (15, '2026-03-17 11:52:23', '127.0.0.1', 'admin@futh', 'patient_vitals', 'add', '---Keys\r\nid : 1\r\n---Fields\r\nencounter_id [new]: 1\r\nrecorded_by [new]: 10\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (16, '2026-03-18 07:35:53', '127.0.0.1', 'a', '', 'failed login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (17, '2026-03-18 07:36:12', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (18, '2026-03-24 07:54:50', '127.0.0.1', 'admin@futh', 'next_of_kin', 'add', '---Keys\r\nid : 1\r\n---Fields\r\npatient_id [new]: 50\r\nfull_name [new]: SHUAIBU MUHAMMAD UMAR\r\nrelationship [new]: PARENT\r\nphone [new]: 08065550005\r\nemail [new]: MSUMAR@ABU.EDU.NG\r\naddress [new]: AHMADU BELLO UNIVERSITY, ZARIA\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (19, '2026-03-25 05:06:18', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (20, '2026-03-25 06:01:21', '127.0.0.1', 'admin@futh', 'next_of_kin', 'add', '---Keys\r\nid : 2\r\n---Fields\r\npatient_id [new]: 44\r\nfull_name [new]: Abdullah Jibril\r\nrelationship [new]: Brother\r\nphone [new]: 07064163237\r\nemail [new]: adbullahij@gmail.com\r\naddress [new]: federal university teaching  hospital, Lafia\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (21, '2026-03-25 06:01:53', '127.0.0.1', 'admin@futh', 'next_of_kin', 'edit', '---Keys\r\nid : 2\r\n---Fields\r\nrelationship [old]: Brother\r\nrelationship [new]: father\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (22, '2026-03-25 07:37:29', '127.0.0.1', 'admin@futh', 'next_of_kin', 'edit', '---Keys\r\nid : 2\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (23, '2026-03-25 07:38:04', '127.0.0.1', 'admin@futh', 'next_of_kin', 'edit', '---Keys\r\nid : 1\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (24, '2026-03-25 09:36:38', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (25, '2026-03-25 10:39:33', '127.0.0.1', 'admin@futh', 'next_of_kin', 'add', '---Keys\r\nid : 3\r\n---Fields\r\npatient_id [new]: 50\r\nfull_name [new]: isah isah\r\nrelationship [new]: son\r\nphone [new]: 07064163237\r\nemail [new]: adbullahij@gmail.com\r\naddress [new]: federal university teaching  hospital, Lafia\r\nnext_of_kin_status_id [new]: 1\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (26, '2026-03-25 11:49:55', '127.0.0.1', 'admin@futh', 'next_of_kin', 'delete', '---Keys\r\nid : 1\r\n---Fields\r\npatient_id [old]: 50\r\nis_primary [old]: 0\r\nnext_of_kin_status_id [old]: 1\r\ncreated_at [old]: 2026-03-24 11:54:47\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (27, '2026-03-25 11:49:56', '127.0.0.1', 'admin@futh', 'next_of_kin', 'delete', '---Keys\r\nid : 2\r\n---Fields\r\npatient_id [old]: 44\r\nis_primary [old]: 0\r\nnext_of_kin_status_id [old]: 1\r\ncreated_at [old]: 2026-03-25 10:01:21\r\n');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (28, '2026-03-27 06:57:35', '127.0.0.1', 'admin@futh', '', 'logout', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (29, '2026-03-27 07:24:22', '127.0.0.1', 'admin@futh', '', 'login', '');
INSERT INTO `futh_emr_audit` (`id`,`datetime`,`ip`,`user`,`table`,`action`,`description`) VALUES (30, '2026-03-29 10:07:18', '127.0.0.1', 'admin@futh', '', 'login', '');

INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (1, 'abdul', '1234567', 'Jibril Abdullahi', 'adbullahij@gmail.com', NULL, '2026-03-10 01:00:00', '2026-03-12 01:00:00', 1, NULL, NULL, NULL);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (2, 'Aliyu', 'ISHA', 'ISHA ALiyu', 'ishaaliyu@futh.com', NULL, '2026-03-12 01:00:00', '2026-03-14 01:00:00', 1, 2, 6, NULL);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (3, 'dr_smith', '$2y$10$dummyHash...', 'Dr. John Smith', 'john.smith@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 1, 1, 2);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (4, 'nurse_joy', '$2y$10$dummyHash...', 'Joy Williams', 'joy.williams@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 1, 2, 3);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (5, 'dr_brown', '$2y$10$dummyHash...', 'Dr. Emily Brown', 'emily.brown@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 1, 5, 2);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (6, 'dr_davis', '$2y$10$dummyHash...', 'Dr. Mark Davis', 'mark.davis@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 1, 3, 2);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (7, 'tech_wilson', '$2y$10$dummyHash...', 'Sarah Wilson', 'sarah.wilson@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 2, 6, 5);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (8, 'tech_garcia', '$2y$10$dummyHash...', 'Carlos Garcia', 'carlos.garcia@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 2, 7, 5);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (9, 'pharm_taylor', '$2y$10$dummyHash...', 'Robert Taylor', 'robert.taylor@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 3, 10, 4);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (10, 'pharm_anderson', '$2y$10$dummyHash...', 'Lisa Anderson', 'lisa.anderson@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 3, 13, 4);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (11, 'hr_thomas', '$2y$10$dummyHash...', 'Kevin Thomas', 'kevin.thomas@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 4, 14, 1);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (12, 'rec_jackson', '$2y$10$dummyHash...', 'Maria Jackson', 'maria.jackson@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 4, 15, 1);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (13, 'acct_white', '$2y$10$dummyHash...', 'Patricia White', 'patricia.white@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 5, 18, 6);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (14, 'acct_martin', '$2y$10$dummyHash...', 'Thomas Martin', 'thomas.martin@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 5, 19, 6);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (15, 'sup_lee', '$2y$10$dummyHash...', 'Bruce Lee', 'bruce.lee@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 6, 23, 7);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (16, 'sup_clark', '$2y$10$dummyHash...', 'Lois Clark', 'lois.clark@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 6, 22, 7);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (17, 'ops_lewis', '$2y$10$dummyHash...', 'David Lewis', 'david.lewis@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 7, 26, 1);
INSERT INTO `users` (`id`,`username`,`password`,`full_name`,`email`,`is_active`,`created_at`,`updated_at`,`hospital_id`,`department_id`,`unit_id`,`role_id`) VALUES (18, 'aud_walker', '$2y$10$dummyHash...', 'Paul Walker', 'paul.walker@hospital.com', 1, '2026-03-17 16:12:57', '2026-03-17 16:12:57', 1, 8, 29, 8);

INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (1, 'Admin', 'System Administrator with full access', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (2, 'Doctor', 'Medical Doctor / Physician', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (3, 'Nurse', 'Registered Nurse', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (4, 'Pharmacist', 'Licensed Pharmacist', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (5, 'Lab Technician', 'Laboratory Staff', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (6, 'Accountant', 'Finance and Billing Staff', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (7, 'Support Staff', 'Maintenance, Security, and Cleaning', '2026-03-17 16:12:27');
INSERT INTO `roles` (`id`,`role_name`,`description`,`created_at`) VALUES (8, 'Auditor', 'Internal Compliance Auditor', '2026-03-17 16:12:27');

INSERT INTO `encounters` (`id`,`patient_id`,`doctor_id`,`department_id`,`encounter_type`,`status`,`encounter_date`,`encounter_time`,`initial_complaint`,`hospital_id`) VALUES (1, 51, 1, NULL, 'Walk-in', 'Waiting', '2026-03-12 01:00:00', NULL, '', 1);

INSERT INTO `hospitals` (`id`,`hospital_name`,`hospital_code`,`hospital_type`,`state`,`lga`,`address`,`phone`,`email`,`is_active`,`created_at`) VALUES (1, 'Annex', '002', 'Secondary', 'Nasarawa', 'Lafia', 'Millionier ', '08133270568', 'adbullahij@gmail.com', NULL, '2026-03-13 01:00:00');
INSERT INTO `hospitals` (`id`,`hospital_name`,`hospital_code`,`hospital_type`,`state`,`lga`,`address`,`phone`,`email`,`is_active`,`created_at`) VALUES (3, 'Taimako', '003', 'Primary', 'Nasarawa', 'Lafia', 'Bukan Ari', '09033270568', 'adbullahij@gmail.com', NULL, '2026-03-12 01:00:00');
INSERT INTO `hospitals` (`id`,`hospital_name`,`hospital_code`,`hospital_type`,`state`,`lga`,`address`,`phone`,`email`,`is_active`,`created_at`) VALUES (4, 'Federal University Teaching Hospital', '001', 'Teaching', 'Nasarawa', 'Lafia', 'Muhammad Buhari Way, off Shandam Road', '08105582371', 'admin@fulth.gov.ng', NULL, '2025-08-12 01:00:00');

INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ABW', 'Aruba', 'North America', 'Caribbean', 193.00, NULL, 103000, 78.4, 828.00, 793.00, 'Aruba', 'Nonmetropolitan Territory of The Netherlands', 'Beatrix', 129, 'AW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AFG', 'Afghanistan', 'Asia', 'Southern and Central Asia', 652090.00, 1919, 22720000, 45.9, 5976.00, NULL, 'Afganistan/Afqanestan', 'Islamic Emirate', 'Mohammad Omar', 1, 'AF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AGO', 'Angola', 'Africa', 'Central Africa', 1246700.00, 1975, 12878000, 38.3, 6648.00, 7984.00, 'Angola', 'Republic', 'José Eduardo dos Santos', 56, 'AO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AIA', 'Anguilla', 'North America', 'Caribbean', 96.00, NULL, 8000, 76.1, 63.20, NULL, 'Anguilla', 'Dependent Territory of the UK', 'Elisabeth II', 62, 'AI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ALB', 'Albania', 'Europe', 'Southern Europe', 28748.00, 1912, 3401200, 71.6, 3205.00, 2500.00, 'Shqipëria', 'Republic', 'Rexhep Mejdani', 34, 'AL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AND', 'Andorra', 'Europe', 'Southern Europe', 468.00, 1278, 78000, 83.5, 1630.00, NULL, 'Andorra', 'Parliamentary Coprincipality', '', 55, 'AD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ANT', 'Netherlands Antilles', 'North America', 'Caribbean', 800.00, NULL, 217000, 74.7, 1941.00, NULL, 'Nederlandse Antillen', 'Nonmetropolitan Territory of The Netherlands', 'Beatrix', 33, 'AN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ARE', 'United Arab Emirates', 'Asia', 'Middle East', 83600.00, 1971, 2441000, 74.1, 37966.00, 36846.00, 'Al-Imarat al-´Arabiya al-Muttahida', 'Emirate Federation', 'Zayid bin Sultan al-Nahayan', 65, 'AE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ARG', 'Argentina', 'South America', 'South America', 2780400.00, 1816, 37032000, 75.1, 340238.00, 323310.00, 'Argentina', 'Federal Republic', 'Fernando de la Rúa', 69, 'AR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ARM', 'Armenia', 'Asia', 'Middle East', 29800.00, 1991, 3520000, 66.4, 1813.00, 1627.00, 'Hajastan', 'Republic', 'Robert Kotšarjan', 126, 'AM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ASM', 'American Samoa', 'Oceania', 'Polynesia', 199.00, NULL, 68000, 75.1, 334.00, NULL, 'Amerika Samoa', 'US Territory', 'George W. Bush', 54, 'AS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ATA', 'Antarctica', 'Antarctica', 'Antarctica', 13120000.00, NULL, 0, NULL, 0.00, NULL, '–', 'Co-administrated', '', NULL, 'AQ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ATF', 'French Southern territories', 'Antarctica', 'Antarctica', 7780.00, NULL, 0, NULL, 0.00, NULL, 'Terres australes françaises', 'Nonmetropolitan Territory of France', 'Jacques Chirac', NULL, 'TF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ATG', 'Antigua and Barbuda', 'North America', 'Caribbean', 442.00, 1981, 68000, 70.5, 612.00, 584.00, 'Antigua and Barbuda', 'Constitutional Monarchy', 'Elisabeth II', 63, 'AG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AUS', 'Australia', 'Oceania', 'Australia and New Zealand', 7741220.00, 1901, 18886000, 79.8, 351182.00, 392911.00, 'Australia', 'Constitutional Monarchy, Federation', 'Elisabeth II', 135, 'AU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AUT', 'Austria', 'Europe', 'Western Europe', 83859.00, 1918, 8091800, 77.7, 211860.00, 206025.00, 'Österreich', 'Federal Republic', 'Thomas Klestil', 1523, 'AT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('AZE', 'Azerbaijan', 'Asia', 'Middle East', 86600.00, 1991, 7734000, 62.9, 4127.00, 4100.00, 'Azərbaycan', 'Republic', 'İlham Əliyev', 144, 'AZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BDI', 'Burundi', 'Africa', 'Eastern Africa', 27834.00, 1962, 6695000, 46.2, 903.00, 982.00, 'Burundi/Uburundi', 'Republic', 'Pierre Buyoya', 552, 'BI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BEL', 'Belgium', 'Europe', 'Western Europe', 30518.00, 1830, 10239000, 77.8, 249704.00, 243948.00, 'België/Belgique', 'Constitutional Monarchy, Federation', 'Albert II', 179, 'BE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BEN', 'Benin', 'Africa', 'Western Africa', 112622.00, 1960, 6097000, 50.2, 2357.00, 2141.00, 'Bénin', 'Republic', 'Mathieu Kérékou', 187, 'BJ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BFA', 'Burkina Faso', 'Africa', 'Western Africa', 274000.00, 1960, 11937000, 46.7, 2425.00, 2201.00, 'Burkina Faso', 'Republic', 'Blaise Compaoré', 549, 'BF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BGD', 'Bangladesh', 'Asia', 'Southern and Central Asia', 143998.00, 1971, 129155000, 60.2, 32852.00, 31966.00, 'Bangladesh', 'Republic', 'Shahabuddin Ahmad', 150, 'BD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BGR', 'Bulgaria', 'Europe', 'Eastern Europe', 110994.00, 1908, 8190900, 70.9, 12178.00, 10169.00, 'Balgarija', 'Republic', 'Petar Stojanov', 539, 'BG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BHR', 'Bahrain', 'Asia', 'Middle East', 694.00, 1971, 617000, 73.0, 6366.00, 6097.00, 'Al-Bahrayn', 'Monarchy (Emirate)', 'Hamad ibn Isa al-Khalifa', 149, 'BH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BHS', 'Bahamas', 'North America', 'Caribbean', 13878.00, 1973, 307000, 71.1, 3527.00, 3347.00, 'The Bahamas', 'Constitutional Monarchy', 'Elisabeth II', 148, 'BS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BIH', 'Bosnia and Herzegovina', 'Europe', 'Southern Europe', 51197.00, 1992, 3972000, 71.5, 2841.00, NULL, 'Bosna i Hercegovina', 'Federal Republic', 'Ante Jelavic', 201, 'BA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BLR', 'Belarus', 'Europe', 'Eastern Europe', 207600.00, 1991, 10236000, 68.0, 13714.00, NULL, 'Belarus', 'Republic', 'Aljaksandr Lukašenka', 3520, 'BY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BLZ', 'Belize', 'North America', 'Central America', 22696.00, 1981, 241000, 70.9, 630.00, 616.00, 'Belize', 'Constitutional Monarchy', 'Elisabeth II', 185, 'BZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BMU', 'Bermuda', 'North America', 'North America', 53.00, NULL, 65000, 76.9, 2328.00, 2190.00, 'Bermuda', 'Dependent Territory of the UK', 'Elisabeth II', 191, 'BM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BOL', 'Bolivia', 'South America', 'South America', 1098581.00, 1825, 8329000, 63.7, 8571.00, 7967.00, 'Bolivia', 'Republic', 'Hugo Bánzer Suárez', 194, 'BO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BRA', 'Brazil', 'South America', 'South America', 8547403.00, 1822, 170115000, 62.9, 776739.00, 804108.00, 'Brasil', 'Federal Republic', 'Fernando Henrique Cardoso', 211, 'BR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BRB', 'Barbados', 'North America', 'Caribbean', 430.00, 1966, 270000, 73.0, 2223.00, 2186.00, 'Barbados', 'Constitutional Monarchy', 'Elisabeth II', 174, 'BB');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BRN', 'Brunei', 'Asia', 'Southeast Asia', 5765.00, 1984, 328000, 73.6, 11705.00, 12460.00, 'Brunei Darussalam', 'Monarchy (Sultanate)', 'Haji Hassan al-Bolkiah', 538, 'BN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BTN', 'Bhutan', 'Asia', 'Southern and Central Asia', 47000.00, 1910, 2124000, 52.4, 372.00, 383.00, 'Druk-Yul', 'Monarchy', 'Jigme Singye Wangchuk', 192, 'BT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BVT', 'Bouvet Island', 'Antarctica', 'Antarctica', 59.00, NULL, 0, NULL, 0.00, NULL, 'Bouvetøya', 'Dependent Territory of Norway', 'Harald V', NULL, 'BV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('BWA', 'Botswana', 'Africa', 'Southern Africa', 581730.00, 1966, 1622000, 39.3, 4834.00, 4935.00, 'Botswana', 'Republic', 'Festus G. Mogae', 204, 'BW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CAF', 'Central African Republic', 'Africa', 'Central Africa', 622984.00, 1960, 3615000, 44.0, 1054.00, 993.00, 'Centrafrique/Bê-Afrîka', 'Republic', 'Ange-Félix Patassé', 1889, 'CF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CAN', 'Canada', 'North America', 'North America', 9970610.00, 1867, 31147000, 79.4, 598862.00, 625626.00, 'Canada', 'Constitutional Monarchy, Federation', 'Elisabeth II', 1822, 'CA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CCK', 'Cocos (Keeling) Islands', 'Oceania', 'Australia and New Zealand', 14.00, NULL, 600, NULL, 0.00, NULL, 'Cocos (Keeling) Islands', 'Territory of Australia', 'Elisabeth II', 2317, 'CC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CHE', 'Switzerland', 'Europe', 'Western Europe', 41284.00, 1499, 7160400, 79.6, 264478.00, 256092.00, 'Schweiz/Suisse/Svizzera/Svizra', 'Federation', 'Adolf Ogi', 3248, 'CH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CHL', 'Chile', 'South America', 'South America', 756626.00, 1810, 15211000, 75.7, 72949.00, 75780.00, 'Chile', 'Republic', 'Ricardo Lagos Escobar', 554, 'CL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CHN', 'China', 'Asia', 'Eastern Asia', 9572900.00, -1523, 1277558000, 71.4, 982268.00, 917719.00, 'Zhongquo', 'People''sRepublic', 'Jiang Zemin', 1891, 'CN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CIV', 'Côte d’Ivoire', 'Africa', 'Western Africa', 322463.00, 1960, 14786000, 45.2, 11345.00, 10285.00, 'Côte d’Ivoire', 'Republic', 'Laurent Gbagbo', 2814, 'CI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CMR', 'Cameroon', 'Africa', 'Central Africa', 475442.00, 1960, 15085000, 54.8, 9174.00, 8596.00, 'Cameroun/Cameroon', 'Republic', 'Paul Biya', 1804, 'CM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('COD', 'Congo, The Democratic Republic of the', 'Africa', 'Central Africa', 2344858.00, 1960, 51654000, 48.8, 6964.00, 2474.00, 'République Démocratique du Congo', 'Republic', 'Joseph Kabila', 2298, 'CD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('COG', 'Congo', 'Africa', 'Central Africa', 342000.00, 1960, 2943000, 47.4, 2108.00, 2287.00, 'Congo', 'Republic', 'Denis Sassou-Nguesso', 2296, 'CG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('COK', 'Cook Islands', 'Oceania', 'Polynesia', 236.00, NULL, 20000, 71.1, 100.00, NULL, 'The Cook Islands', 'Nonmetropolitan Territory of New Zealand', 'Elisabeth II', 583, 'CK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('COL', 'Colombia', 'South America', 'South America', 1138914.00, 1810, 42321000, 70.3, 102896.00, 105116.00, 'Colombia', 'Republic', 'Andrés Pastrana Arango', 2257, 'CO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('COM', 'Comoros', 'Africa', 'Eastern Africa', 1862.00, 1975, 578000, 60.0, 4401.00, 4361.00, 'Komori/Comores', 'Republic', 'Azali Assoumani', 2295, 'KM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CPV', 'Cape Verde', 'Africa', 'Western Africa', 4033.00, 1975, 428000, 68.9, 435.00, 420.00, 'Cabo Verde', 'Republic', 'António Mascarenhas Monteiro', 1859, 'CV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CRI', 'Costa Rica', 'North America', 'Central America', 51100.00, 1821, 4023000, 75.8, 10226.00, 9757.00, 'Costa Rica', 'Republic', 'Miguel Ángel Rodríguez Echeverría', 584, 'CR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CUB', 'Cuba', 'North America', 'Caribbean', 110861.00, 1902, 11201000, 76.2, 17843.00, 18862.00, 'Cuba', 'Socialistic Republic', 'Fidel Castro Ruz', 2413, 'CU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CXR', 'Christmas Island', 'Oceania', 'Australia and New Zealand', 135.00, NULL, 2500, NULL, 0.00, NULL, 'Christmas Island', 'Territory of Australia', 'Elisabeth II', 1791, 'CX');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CYM', 'Cayman Islands', 'North America', 'Caribbean', 264.00, NULL, 38000, 78.9, 1263.00, 1186.00, 'Cayman Islands', 'Dependent Territory of the UK', 'Elisabeth II', 553, 'KY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CYP', 'Cyprus', 'Asia', 'Middle East', 9251.00, 1960, 754700, 76.7, 9333.00, 8246.00, 'Kýpros/Kibris', 'Republic', 'Glafkos Klerides', 2430, 'CY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('CZE', 'Czech Republic', 'Europe', 'Eastern Europe', 78866.00, 1993, 10278100, 74.5, 55017.00, 52037.00, '¸esko', 'Republic', 'Václav Havel', 3339, 'CZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DEU', 'Germany', 'Europe', 'Western Europe', 357022.00, 1955, 82164700, 77.4, 2133367.00, 2102826.00, 'Deutschland', 'Federal Republic', 'Johannes Rau', 3068, 'DE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DJI', 'Djibouti', 'Africa', 'Eastern Africa', 23200.00, 1977, 638000, 50.8, 382.00, 373.00, 'Djibouti/Jibuti', 'Republic', 'Ismail Omar Guelleh', 585, 'DJ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DMA', 'Dominica', 'North America', 'Caribbean', 751.00, 1978, 71000, 73.4, 256.00, 243.00, 'Dominica', 'Republic', 'Vernon Shaw', 586, 'DM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DNK', 'Denmark', 'Europe', 'Nordic Countries', 43094.00, 800, 5330000, 76.5, 174099.00, 169264.00, 'Danmark', 'Constitutional Monarchy', 'Margrethe II', 3315, 'DK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DOM', 'Dominican Republic', 'North America', 'Caribbean', 48511.00, 1844, 8495000, 73.2, 15846.00, 15076.00, 'República Dominicana', 'Republic', 'Hipólito Mejía Domínguez', 587, 'DO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('DZA', 'Algeria', 'Africa', 'Northern Africa', 2381741.00, 1962, 31471000, 69.7, 49982.00, 46966.00, 'Al-Jaza’ir/Algérie', 'Republic', 'Abdelaziz Bouteflika', 35, 'DZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ECU', 'Ecuador', 'South America', 'South America', 283561.00, 1822, 12646000, 71.1, 19770.00, 19769.00, 'Ecuador', 'Republic', 'Gustavo Noboa Bejarano', 594, 'EC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('EGY', 'Egypt', 'Africa', 'Northern Africa', 1001449.00, 1922, 68470000, 63.3, 82710.00, 75617.00, 'Misr', 'Republic', 'Hosni Mubarak', 608, 'EG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ERI', 'Eritrea', 'Africa', 'Eastern Africa', 117600.00, 1993, 3850000, 55.8, 650.00, 755.00, 'Ertra', 'Republic', 'Isayas Afewerki [Isaias Afwerki]', 652, 'ER');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ESH', 'Western Sahara', 'Africa', 'Northern Africa', 266000.00, NULL, 293000, 49.8, 60.00, NULL, 'As-Sahrawiya', 'Occupied by Marocco', 'Mohammed Abdel Aziz', 2453, 'EH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ESP', 'Spain', 'Europe', 'Southern Europe', 505992.00, 1492, 39441700, 78.8, 553233.00, 532031.00, 'España', 'Constitutional Monarchy', 'Juan Carlos I', 653, 'ES');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('EST', 'Estonia', 'Europe', 'Baltic Countries', 45227.00, 1991, 1439200, 69.5, 5328.00, 3371.00, 'Eesti', 'Republic', 'Lennart Meri', 3791, 'EE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ETH', 'Ethiopia', 'Africa', 'Eastern Africa', 1104300.00, -1000, 62565000, 45.2, 6353.00, 6180.00, 'YeItyop´iya', 'Republic', 'Negasso Gidada', 756, 'ET');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FIN', 'Finland', 'Europe', 'Nordic Countries', 338145.00, 1917, 5171300, 77.4, 121914.00, 119833.00, 'Suomi', 'Republic', 'Tarja Halonen', 3236, 'FI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FJI', 'Fiji Islands', 'Oceania', 'Melanesia', 18274.00, 1970, 817000, 67.9, 1536.00, 2149.00, 'Fiji Islands', 'Republic', 'Josefa Iloilo', 764, 'FJ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FLK', 'Falkland Islands', 'South America', 'South America', 12173.00, NULL, 2000, NULL, 0.00, NULL, 'Falkland Islands', 'Dependent Territory of the UK', 'Elisabeth II', 763, 'FK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FRA', 'France', 'Europe', 'Western Europe', 551500.00, 843, 59225700, 78.8, 1424285.00, 1392448.00, 'France', 'Republic', 'Jacques Chirac', 2974, 'FR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FRO', 'Faroe Islands', 'Europe', 'Nordic Countries', 1399.00, NULL, 43000, 78.4, 0.00, NULL, 'Føroyar', 'Part of Denmark', 'Margrethe II', 901, 'FO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('FSM', 'Micronesia, Federated States of', 'Oceania', 'Micronesia', 702.00, 1990, 119000, 68.6, 212.00, NULL, 'Micronesia', 'Federal Republic', 'Leo A. Falcam', 2689, 'FM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GAB', 'Gabon', 'Africa', 'Central Africa', 267668.00, 1960, 1226000, 50.1, 5493.00, 5279.00, 'Le Gabon', 'Republic', 'Omar Bongo', 902, 'GA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GBR', 'United Kingdom', 'Europe', 'British Islands', 242900.00, 1066, 59623400, 77.7, 1378330.00, 1296830.00, 'United Kingdom', 'Constitutional Monarchy', 'Elisabeth II', 456, 'GB');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GEO', 'Georgia', 'Asia', 'Middle East', 69700.00, 1991, 4968000, 64.5, 6064.00, 5924.00, 'Sakartvelo', 'Republic', 'Eduard Ševardnadze', 905, 'GE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GHA', 'Ghana', 'Africa', 'Western Africa', 238533.00, 1957, 20212000, 57.4, 7137.00, 6884.00, 'Ghana', 'Republic', 'John Kufuor', 910, 'GH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GIB', 'Gibraltar', 'Europe', 'Southern Europe', 6.00, NULL, 25000, 79.0, 258.00, NULL, 'Gibraltar', 'Dependent Territory of the UK', 'Elisabeth II', 915, 'GI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GIN', 'Guinea', 'Africa', 'Western Africa', 245857.00, 1958, 7430000, 45.6, 2352.00, 2383.00, 'Guinée', 'Republic', 'Lansana Conté', 926, 'GN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GLP', 'Guadeloupe', 'North America', 'Caribbean', 1705.00, NULL, 456000, 77.0, 3501.00, NULL, 'Guadeloupe', 'Overseas Department of France', 'Jacques Chirac', 919, 'GP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GMB', 'Gambia', 'Africa', 'Western Africa', 11295.00, 1965, 1305000, 53.2, 320.00, 325.00, 'The Gambia', 'Republic', 'Yahya Jammeh', 904, 'GM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GNB', 'Guinea-Bissau', 'Africa', 'Western Africa', 36125.00, 1974, 1213000, 49.0, 293.00, 272.00, 'Guiné-Bissau', 'Republic', 'Kumba Ialá', 927, 'GW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GNQ', 'Equatorial Guinea', 'Africa', 'Central Africa', 28051.00, 1968, 453000, 53.6, 283.00, 542.00, 'Guinea Ecuatorial', 'Republic', 'Teodoro Obiang Nguema Mbasogo', 2972, 'GQ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GRC', 'Greece', 'Europe', 'Southern Europe', 131626.00, 1830, 10545700, 78.4, 120724.00, 119946.00, 'Elláda', 'Republic', 'Kostis Stefanopoulos', 2401, 'GR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GRD', 'Grenada', 'North America', 'Caribbean', 344.00, 1974, 94000, 64.5, 318.00, NULL, 'Grenada', 'Constitutional Monarchy', 'Elisabeth II', 916, 'GD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GRL', 'Greenland', 'North America', 'North America', 2166090.00, NULL, 56000, 68.1, 0.00, NULL, 'Kalaallit Nunaat/Grønland', 'Part of Denmark', 'Margrethe II', 917, 'GL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GTM', 'Guatemala', 'North America', 'Central America', 108889.00, 1821, 11385000, 66.2, 19008.00, 17797.00, 'Guatemala', 'Republic', 'Alfonso Portillo Cabrera', 922, 'GT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GUF', 'French Guiana', 'South America', 'South America', 90000.00, NULL, 181000, 76.1, 681.00, NULL, 'Guyane française', 'Overseas Department of France', 'Jacques Chirac', 3014, 'GF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GUM', 'Guam', 'Oceania', 'Micronesia', 549.00, NULL, 168000, 77.8, 1197.00, 1136.00, 'Guam', 'US Territory', 'George W. Bush', 921, 'GU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('GUY', 'Guyana', 'South America', 'South America', 214969.00, 1966, 861000, 64.0, 722.00, 743.00, 'Guyana', 'Republic', 'Bharrat Jagdeo', 928, 'GY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HKG', 'Hong Kong', 'Asia', 'Eastern Asia', 1075.00, NULL, 6782000, 79.5, 166448.00, 173610.00, 'Xianggang/Hong Kong', 'Special Administrative Region of China', 'Jiang Zemin', 937, 'HK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HMD', 'Heard Island and McDonald Islands', 'Antarctica', 'Antarctica', 359.00, NULL, 0, NULL, 0.00, NULL, 'Heard and McDonald Islands', 'Territory of Australia', 'Elisabeth II', NULL, 'HM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HND', 'Honduras', 'North America', 'Central America', 112088.00, 1838, 6485000, 69.9, 5333.00, 4697.00, 'Honduras', 'Republic', 'Carlos Roberto Flores Facussé', 933, 'HN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HRV', 'Croatia', 'Europe', 'Southern Europe', 56538.00, 1991, 4473000, 73.7, 20208.00, 19300.00, 'Hrvatska', 'Republic', 'Štipe Mesic', 2409, 'HR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HTI', 'Haiti', 'North America', 'Caribbean', 27750.00, 1804, 8222000, 49.2, 3459.00, 3107.00, 'Haïti/Dayti', 'Republic', 'Jean-Bertrand Aristide', 929, 'HT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('HUN', 'Hungary', 'Europe', 'Eastern Europe', 93030.00, 1918, 10043200, 71.4, 48267.00, 45914.00, 'Magyarország', 'Republic', 'Ferenc Mádl', 3483, 'HU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IDN', 'Indonesia', 'Asia', 'Southeast Asia', 1904569.00, 1945, 212107000, 68.0, 84982.00, 215002.00, 'Indonesia', 'Republic', 'Abdurrahman Wahid', 939, 'ID');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IND', 'India', 'Asia', 'Southern and Central Asia', 3287263.00, 1947, 1013662000, 62.5, 447114.00, 430572.00, 'Bharat/India', 'Federal Republic', 'Kocheril Raman Narayanan', 1109, 'IN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IOT', 'British Indian Ocean Territory', 'Africa', 'Eastern Africa', 78.00, NULL, 0, NULL, 0.00, NULL, 'British Indian Ocean Territory', 'Dependent Territory of the UK', 'Elisabeth II', NULL, 'IO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IRL', 'Ireland', 'Europe', 'British Islands', 70273.00, 1921, 3775100, 76.8, 75921.00, 73132.00, 'Ireland/Éire', 'Republic', 'Mary McAleese', 1447, 'IE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IRN', 'Iran', 'Asia', 'Southern and Central Asia', 1648195.00, 1906, 67702000, 69.7, 195746.00, 160151.00, 'Iran', 'Islamic Republic', 'Ali Mohammad Khatami-Ardakani', 1380, 'IR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('IRQ', 'Iraq', 'Asia', 'Middle East', 438317.00, 1932, 23115000, 66.5, 11500.00, NULL, 'Al-´Iraq', 'Republic', 'Saddam Hussein al-Takriti', 1365, 'IQ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ISL', 'Iceland', 'Europe', 'Nordic Countries', 103000.00, 1944, 279000, 79.4, 8255.00, 7474.00, 'Ísland', 'Republic', 'Ólafur Ragnar Grímsson', 1449, 'IS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ISR', 'Israel', 'Asia', 'Middle East', 21056.00, 1948, 6217000, 78.6, 97477.00, 98577.00, 'Yisra’el/Isra’il', 'Republic', 'Moshe Katzav', 1450, 'IL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ITA', 'Italy', 'Europe', 'Southern Europe', 301316.00, 1861, 57680000, 79.0, 1161755.00, 1145372.00, 'Italia', 'Republic', 'Carlo Azeglio Ciampi', 1464, 'IT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('JAM', 'Jamaica', 'North America', 'Caribbean', 10990.00, 1962, 2583000, 75.2, 6871.00, 6722.00, 'Jamaica', 'Constitutional Monarchy', 'Elisabeth II', 1530, 'JM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('JOR', 'Jordan', 'Asia', 'Middle East', 88946.00, 1946, 5083000, 77.4, 7526.00, 7051.00, 'Al-Urdunn', 'Constitutional Monarchy', 'Abdullah II', 1786, 'JO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('JPN', 'Japan', 'Asia', 'Eastern Asia', 377829.00, -660, 126714000, 80.7, 3787042.00, 4192638.00, 'Nihon/Nippon', 'Constitutional Monarchy', 'Akihito', 1532, 'JP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KAZ', 'Kazakstan', 'Asia', 'Southern and Central Asia', 2724900.00, 1991, 16223000, 63.2, 24375.00, 23383.00, 'Qazaqstan', 'Republic', 'Nursultan Nazarbajev', 1864, 'KZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KEN', 'Kenya', 'Africa', 'Eastern Africa', 580367.00, 1963, 30080000, 48.0, 9217.00, 10241.00, 'Kenya', 'Republic', 'Daniel arap Moi', 1881, 'KE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KGZ', 'Kyrgyzstan', 'Asia', 'Southern and Central Asia', 199900.00, 1991, 4699000, 63.4, 1626.00, 1767.00, 'Kyrgyzstan', 'Republic', 'Askar Akajev', 2253, 'KG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KHM', 'Cambodia', 'Asia', 'Southeast Asia', 181035.00, 1953, 11168000, 56.5, 5121.00, 5670.00, 'Kâmpuchéa', 'Constitutional Monarchy', 'Norodom Sihanouk', 1800, 'KH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KIR', 'Kiribati', 'Oceania', 'Micronesia', 726.00, 1979, 83000, 59.8, 40.70, NULL, 'Kiribati', 'Republic', 'Teburoro Tito', 2256, 'KI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KNA', 'Saint Kitts and Nevis', 'North America', 'Caribbean', 261.00, 1983, 38000, 70.7, 299.00, NULL, 'Saint Kitts and Nevis', 'Constitutional Monarchy', 'Elisabeth II', 3064, 'KN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KOR', 'South Korea', 'Asia', 'Eastern Asia', 99434.00, 1948, 46844000, 74.4, 320749.00, 442544.00, 'Taehan Min’guk (Namhan)', 'Republic', 'Kim Dae-jung', 2331, 'KR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('KWT', 'Kuwait', 'Asia', 'Middle East', 17818.00, 1961, 1972000, 76.1, 27037.00, 30373.00, 'Al-Kuwayt', 'Constitutional Monarchy (Emirate)', 'Jabir al-Ahmad al-Jabir al-Sabah', 2429, 'KW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LAO', 'Laos', 'Asia', 'Southeast Asia', 236800.00, 1953, 5433000, 53.1, 1292.00, 1746.00, 'Lao', 'Republic', 'Khamtay Siphandone', 2432, 'LA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LBN', 'Lebanon', 'Asia', 'Middle East', 10400.00, 1941, 3282000, 71.3, 17121.00, 15129.00, 'Lubnan', 'Republic', 'Émile Lahoud', 2438, 'LB');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LBR', 'Liberia', 'Africa', 'Western Africa', 111369.00, 1847, 3154000, 51.0, 2012.00, NULL, 'Liberia', 'Republic', 'Charles Taylor', 2440, 'LR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LBY', 'Libyan Arab Jamahiriya', 'Africa', 'Northern Africa', 1759540.00, 1951, 5605000, 75.5, 44806.00, 40562.00, 'Libiya', 'Socialistic State', 'Muammar al-Qadhafi', 2441, 'LY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LCA', 'Saint Lucia', 'North America', 'Caribbean', 622.00, 1979, 154000, 72.3, 571.00, NULL, 'Saint Lucia', 'Constitutional Monarchy', 'Elisabeth II', 3065, 'LC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LIE', 'Liechtenstein', 'Europe', 'Western Europe', 160.00, 1806, 32300, 78.8, 1119.00, 1084.00, 'Liechtenstein', 'Constitutional Monarchy', 'Hans-Adam II', 2446, 'LI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LKA', 'Sri Lanka', 'Asia', 'Southern and Central Asia', 65610.00, 1948, 18827000, 71.8, 15706.00, 15091.00, 'Sri Lanka/Ilankai', 'Republic', 'Chandrika Kumaratunga', 3217, 'LK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LSO', 'Lesotho', 'Africa', 'Southern Africa', 30355.00, 1966, 2153000, 50.8, 1061.00, 1161.00, 'Lesotho', 'Constitutional Monarchy', 'Letsie III', 2437, 'LS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LTU', 'Lithuania', 'Europe', 'Baltic Countries', 65301.00, 1991, 3698500, 69.1, 10692.00, 9585.00, 'Lietuva', 'Republic', 'Valdas Adamkus', 2447, 'LT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LUX', 'Luxembourg', 'Europe', 'Western Europe', 2586.00, 1867, 435700, 77.1, 16321.00, 15519.00, 'Luxembourg/Lëtzebuerg', 'Constitutional Monarchy', 'Henri', 2452, 'LU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('LVA', 'Latvia', 'Europe', 'Baltic Countries', 64589.00, 1991, 2424200, 68.4, 6398.00, 5639.00, 'Latvija', 'Republic', 'Vaira Vike-Freiberga', 2434, 'LV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MAC', 'Macao', 'Asia', 'Eastern Asia', 18.00, NULL, 473000, 81.6, 5749.00, 5940.00, 'Macau/Aomen', 'Special Administrative Region of China', 'Jiang Zemin', 2454, 'MO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MAR', 'Morocco', 'Africa', 'Northern Africa', 446550.00, 1956, 28351000, 69.1, 36124.00, 33514.00, 'Al-Maghrib', 'Constitutional Monarchy', 'Mohammed VI', 2486, 'MA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MCO', 'Monaco', 'Europe', 'Western Europe', 1.50, 1861, 34000, 78.8, 776.00, NULL, 'Monaco', 'Constitutional Monarchy', 'Rainier III', 2695, 'MC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MDA', 'Moldova', 'Europe', 'Eastern Europe', 33851.00, 1991, 4380000, 64.5, 1579.00, 1872.00, 'Moldova', 'Republic', 'Vladimir Voronin', 2690, 'MD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MDG', 'Madagascar', 'Africa', 'Eastern Africa', 587041.00, 1960, 15942000, 55.0, 3750.00, 3545.00, 'Madagasikara/Madagascar', 'Federal Republic', 'Didier Ratsiraka', 2455, 'MG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MDV', 'Maldives', 'Asia', 'Southern and Central Asia', 298.00, 1965, 286000, 62.2, 199.00, NULL, 'Dhivehi Raajje/Maldives', 'Republic', 'Maumoon Abdul Gayoom', 2463, 'MV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MEX', 'Mexico', 'North America', 'Central America', 1958201.00, 1810, 98881000, 71.5, 414972.00, 401461.00, 'México', 'Federal Republic', 'Vicente Fox Quesada', 2515, 'MX');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MHL', 'Marshall Islands', 'Oceania', 'Micronesia', 181.00, 1990, 64000, 65.5, 97.00, NULL, 'Marshall Islands/Majol', 'Republic', 'Kessai Note', 2507, 'MH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MKD', 'Macedonia', 'Europe', 'Southern Europe', 25713.00, 1991, 2024000, 73.8, 1694.00, 1915.00, 'Makedonija', 'Republic', 'Boris Trajkovski', 2460, 'MK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MLI', 'Mali', 'Africa', 'Western Africa', 1240192.00, 1960, 11234000, 46.7, 2642.00, 2453.00, 'Mali', 'Republic', 'Alpha Oumar Konaré', 2482, 'ML');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MLT', 'Malta', 'Europe', 'Southern Europe', 316.00, 1964, 380200, 77.9, 3512.00, 3338.00, 'Malta', 'Republic', 'Guido de Marco', 2484, 'MT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MMR', 'Myanmar', 'Asia', 'Southeast Asia', 676578.00, 1948, 45611000, 54.9, 180375.00, 171028.00, 'Myanma Pye', 'Republic', 'kenraali Than Shwe', 2710, 'MM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MNG', 'Mongolia', 'Asia', 'Eastern Asia', 1566500.00, 1921, 2662000, 67.3, 1043.00, 933.00, 'Mongol Uls', 'Republic', 'Natsagiin Bagabandi', 2696, 'MN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MNP', 'Northern Mariana Islands', 'Oceania', 'Micronesia', 464.00, NULL, 78000, 75.5, 0.00, NULL, 'Northern Mariana Islands', 'Commonwealth of the US', 'George W. Bush', 2913, 'MP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MOZ', 'Mozambique', 'Africa', 'Eastern Africa', 801590.00, 1975, 19680000, 37.5, 2891.00, 2711.00, 'Moçambique', 'Republic', 'Joaquím A. Chissano', 2698, 'MZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MRT', 'Mauritania', 'Africa', 'Western Africa', 1025520.00, 1960, 2670000, 50.8, 998.00, 1081.00, 'Muritaniya/Mauritanie', 'Republic', 'Maaouiya Ould Sid´Ahmad Taya', 2509, 'MR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MSR', 'Montserrat', 'North America', 'Caribbean', 102.00, NULL, 11000, 78.0, 109.00, NULL, 'Montserrat', 'Dependent Territory of the UK', 'Elisabeth II', 2697, 'MS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MTQ', 'Martinique', 'North America', 'Caribbean', 1102.00, NULL, 395000, 78.3, 2731.00, 2559.00, 'Martinique', 'Overseas Department of France', 'Jacques Chirac', 2508, 'MQ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MUS', 'Mauritius', 'Africa', 'Eastern Africa', 2040.00, 1968, 1158000, 71.0, 4251.00, 4186.00, 'Mauritius', 'Republic', 'Cassam Uteem', 2511, 'MU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MWI', 'Malawi', 'Africa', 'Eastern Africa', 118484.00, 1964, 10925000, 37.6, 1687.00, 2527.00, 'Malawi', 'Republic', 'Bakili Muluzi', 2462, 'MW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MYS', 'Malaysia', 'Asia', 'Southeast Asia', 329758.00, 1957, 22244000, 70.8, 69213.00, 97884.00, 'Malaysia', 'Constitutional Monarchy, Federation', 'Salahuddin Abdul Aziz Shah Alhaj', 2464, 'MY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('MYT', 'Mayotte', 'Africa', 'Eastern Africa', 373.00, NULL, 149000, 59.5, 0.00, NULL, 'Mayotte', 'Territorial Collectivity of France', 'Jacques Chirac', 2514, 'YT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NAM', 'Namibia', 'Africa', 'Southern Africa', 824292.00, 1990, 1726000, 42.5, 3101.00, 3384.00, 'Namibia', 'Republic', 'Sam Nujoma', 2726, 'NA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NCL', 'New Caledonia', 'Oceania', 'Melanesia', 18575.00, NULL, 214000, 72.8, 3563.00, NULL, 'Nouvelle-Calédonie', 'Nonmetropolitan Territory of France', 'Jacques Chirac', 3493, 'NC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NER', 'Niger', 'Africa', 'Western Africa', 1267000.00, 1960, 10730000, 41.3, 1706.00, 1580.00, 'Niger', 'Republic', 'Mamadou Tandja', 2738, 'NE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NFK', 'Norfolk Island', 'Oceania', 'Australia and New Zealand', 36.00, NULL, 2000, NULL, 0.00, NULL, 'Norfolk Island', 'Territory of Australia', 'Elisabeth II', 2806, 'NF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NGA', 'Nigeria', 'Africa', 'Western Africa', 923768.00, 1960, 111506000, 51.6, 65707.00, 58623.00, 'Nigeria', 'Federal Republic', 'Olusegun Obasanjo', 2754, 'NG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NIC', 'Nicaragua', 'North America', 'Central America', 130000.00, 1838, 5074000, 68.7, 1988.00, 2023.00, 'Nicaragua', 'Republic', 'Arnoldo Alemán Lacayo', 2734, 'NI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NIU', 'Niue', 'Oceania', 'Polynesia', 260.00, NULL, 2000, NULL, 0.00, NULL, 'Niue', 'Nonmetropolitan Territory of New Zealand', 'Elisabeth II', 2805, 'NU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NLD', 'Netherlands', 'Europe', 'Western Europe', 41526.00, 1581, 15864000, 78.3, 371362.00, 360478.00, 'Nederland', 'Constitutional Monarchy', 'Beatrix', 5, 'NL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NOR', 'Norway', 'Europe', 'Nordic Countries', 323877.00, 1905, 4478500, 78.7, 145895.00, 153370.00, 'Norge', 'Constitutional Monarchy', 'Harald V', 2807, 'NO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NPL', 'Nepal', 'Asia', 'Southern and Central Asia', 147181.00, 1769, 23930000, 57.8, 4768.00, 4837.00, 'Nepal', 'Constitutional Monarchy', 'Gyanendra Bir Bikram', 2729, 'NP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NRU', 'Nauru', 'Oceania', 'Micronesia', 21.00, 1968, 12000, 60.8, 197.00, NULL, 'Naoero/Nauru', 'Republic', 'Bernard Dowiyogo', 2728, 'NR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('NZL', 'New Zealand', 'Oceania', 'Australia and New Zealand', 270534.00, 1907, 3862000, 77.8, 54669.00, 64960.00, 'New Zealand/Aotearoa', 'Constitutional Monarchy', 'Elisabeth II', 3499, 'NZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('OMN', 'Oman', 'Asia', 'Middle East', 309500.00, 1951, 2542000, 71.8, 16904.00, 16153.00, '´Uman', 'Monarchy (Sultanate)', 'Qabus ibn Sa´id', 2821, 'OM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PAK', 'Pakistan', 'Asia', 'Southern and Central Asia', 796095.00, 1947, 156483000, 61.1, 61289.00, 58549.00, 'Pakistan', 'Republic', 'Mohammad Rafiq Tarar', 2831, 'PK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PAN', 'Panama', 'North America', 'Central America', 75517.00, 1903, 2856000, 75.5, 9131.00, 8700.00, 'Panamá', 'Republic', 'Mireya Elisa Moscoso Rodríguez', 2882, 'PA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PCN', 'Pitcairn', 'Oceania', 'Polynesia', 49.00, NULL, 50, NULL, 0.00, NULL, 'Pitcairn', 'Dependent Territory of the UK', 'Elisabeth II', 2912, 'PN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PER', 'Peru', 'South America', 'South America', 1285216.00, 1821, 25662000, 70.0, 64140.00, 65186.00, 'Perú/Piruw', 'Republic', 'Valentin Paniagua Corazao', 2890, 'PE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PHL', 'Philippines', 'Asia', 'Southeast Asia', 300000.00, 1946, 75967000, 67.5, 65107.00, 82239.00, 'Pilipinas', 'Republic', 'Gloria Macapagal-Arroyo', 766, 'PH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PLW', 'Palau', 'Oceania', 'Micronesia', 459.00, 1994, 19000, 68.6, 105.00, NULL, 'Belau/Palau', 'Republic', 'Kuniwo Nakamura', 2881, 'PW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PNG', 'Papua New Guinea', 'Oceania', 'Melanesia', 462840.00, 1975, 4807000, 63.1, 4988.00, 6328.00, 'Papua New Guinea/Papua Niugini', 'Constitutional Monarchy', 'Elisabeth II', 2884, 'PG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('POL', 'Poland', 'Europe', 'Eastern Europe', 323250.00, 1918, 38653600, 73.2, 151697.00, 135636.00, 'Polska', 'Republic', 'Aleksander Kwasniewski', 2928, 'PL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PRI', 'Puerto Rico', 'North America', 'Caribbean', 8875.00, NULL, 3869000, 75.6, 34100.00, 32100.00, 'Puerto Rico', 'Commonwealth of the US', 'George W. Bush', 2919, 'PR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PRK', 'North Korea', 'Asia', 'Eastern Asia', 120538.00, 1948, 24039000, 70.7, 5332.00, NULL, 'Choson Minjujuui In´min Konghwaguk (Bukhan)', 'Socialistic Republic', 'Kim Jong-il', 2318, 'KP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PRT', 'Portugal', 'Europe', 'Southern Europe', 91982.00, 1143, 9997600, 75.8, 105954.00, 102133.00, 'Portugal', 'Republic', 'Jorge Sampãio', 2914, 'PT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PRY', 'Paraguay', 'South America', 'South America', 406752.00, 1811, 5496000, 73.7, 8444.00, 9555.00, 'Paraguay', 'Republic', 'Luis Ángel González Macchi', 2885, 'PY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PSE', 'Palestine', 'Asia', 'Middle East', 6257.00, NULL, 3101000, 71.4, 4173.00, NULL, 'Filastin', 'Autonomous Area', 'Yasser (Yasir) Arafat', 4074, 'PS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('PYF', 'French Polynesia', 'Oceania', 'Polynesia', 4000.00, NULL, 235000, 74.8, 818.00, 781.00, 'Polynésie française', 'Nonmetropolitan Territory of France', 'Jacques Chirac', 3016, 'PF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('QAT', 'Qatar', 'Asia', 'Middle East', 11000.00, 1971, 599000, 72.4, 9472.00, 8920.00, 'Qatar', 'Monarchy', 'Hamad ibn Khalifa al-Thani', 2973, 'QA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('REU', 'Réunion', 'Africa', 'Eastern Africa', 2510.00, NULL, 699000, 72.7, 8287.00, 7988.00, 'Réunion', 'Overseas Department of France', 'Jacques Chirac', 3017, 'RE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ROM', 'Romania', 'Europe', 'Eastern Europe', 238391.00, 1878, 22455500, 69.9, 38158.00, 34843.00, 'România', 'Republic', 'Ion Iliescu', 3018, 'RO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('RUS', 'Russian Federation', 'Europe', 'Eastern Europe', 17075400.00, 1991, 146934000, 67.2, 276608.00, 442989.00, 'Rossija', 'Federal Republic', 'Vladimir Putin', 3580, 'RU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('RWA', 'Rwanda', 'Africa', 'Eastern Africa', 26338.00, 1962, 7733000, 39.3, 2036.00, 1863.00, 'Rwanda/Urwanda', 'Republic', 'Paul Kagame', 3047, 'RW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SAU', 'Saudi Arabia', 'Asia', 'Middle East', 2149690.00, 1932, 21607000, 67.8, 137635.00, 146171.00, 'Al-´Arabiya as-Sa´udiya', 'Monarchy', 'Fahd ibn Abdul-Aziz al-Sa´ud', 3173, 'SA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SDN', 'Sudan', 'Africa', 'Northern Africa', 2505813.00, 1956, 29490000, 56.6, 10162.00, NULL, 'As-Sudan', 'Islamic Republic', 'Omar Hassan Ahmad al-Bashir', 3225, 'SD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SEN', 'Senegal', 'Africa', 'Western Africa', 196722.00, 1960, 9481000, 62.2, 4787.00, 4542.00, 'Sénégal/Sounougal', 'Republic', 'Abdoulaye Wade', 3198, 'SN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SGP', 'Singapore', 'Asia', 'Southeast Asia', 618.00, 1965, 3567000, 80.1, 86503.00, 96318.00, 'Singapore/Singapura/Xinjiapo/Singapur', 'Republic', 'Sellapan Rama Nathan', 3208, 'SG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SGS', 'South Georgia and the South Sandwich Islands', 'Antarctica', 'Antarctica', 3903.00, NULL, 0, NULL, 0.00, NULL, 'South Georgia and the South Sandwich Islands', 'Dependent Territory of the UK', 'Elisabeth II', NULL, 'GS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SHN', 'Saint Helena', 'Africa', 'Western Africa', 314.00, NULL, 6000, 76.8, 0.00, NULL, 'Saint Helena', 'Dependent Territory of the UK', 'Elisabeth II', 3063, 'SH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SJM', 'Svalbard and Jan Mayen', 'Europe', 'Nordic Countries', 62422.00, NULL, 3200, NULL, 0.00, NULL, 'Svalbard og Jan Mayen', 'Dependent Territory of Norway', 'Harald V', 938, 'SJ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SLB', 'Solomon Islands', 'Oceania', 'Melanesia', 28896.00, 1978, 444000, 71.3, 182.00, 220.00, 'Solomon Islands', 'Constitutional Monarchy', 'Elisabeth II', 3161, 'SB');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SLE', 'Sierra Leone', 'Africa', 'Western Africa', 71740.00, 1961, 4854000, 45.3, 746.00, 858.00, 'Sierra Leone', 'Republic', 'Ahmed Tejan Kabbah', 3207, 'SL');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SLV', 'El Salvador', 'North America', 'Central America', 21041.00, 1841, 6276000, 69.7, 11863.00, 11203.00, 'El Salvador', 'Republic', 'Francisco Guillermo Flores Pérez', 645, 'SV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SMR', 'San Marino', 'Europe', 'Southern Europe', 61.00, 885, 27000, 81.1, 510.00, NULL, 'San Marino', 'Republic', NULL, 3171, 'SM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SOM', 'Somalia', 'Africa', 'Eastern Africa', 637657.00, 1960, 10097000, 46.2, 935.00, NULL, 'Soomaaliya', 'Republic', 'Abdiqassim Salad Hassan', 3214, 'SO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SPM', 'Saint Pierre and Miquelon', 'North America', 'North America', 242.00, NULL, 7000, 77.6, 0.00, NULL, 'Saint-Pierre-et-Miquelon', 'Territorial Collectivity of France', 'Jacques Chirac', 3067, 'PM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('STP', 'Sao Tome and Principe', 'Africa', 'Central Africa', 964.00, 1975, 147000, 65.3, 6.00, NULL, 'São Tomé e Príncipe', 'Republic', 'Miguel Trovoada', 3172, 'ST');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SUR', 'Suriname', 'South America', 'South America', 163265.00, 1975, 417000, 71.4, 870.00, 706.00, 'Suriname', 'Republic', 'Ronald Venetiaan', 3243, 'SR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SVK', 'Slovakia', 'Europe', 'Eastern Europe', 49012.00, 1993, 5398700, 73.7, 20594.00, 19452.00, 'Slovensko', 'Republic', 'Rudolf Schuster', 3209, 'SK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SVN', 'Slovenia', 'Europe', 'Southern Europe', 20256.00, 1991, 1987800, 74.9, 19756.00, 18202.00, 'Slovenija', 'Republic', 'Milan Kucan', 3212, 'SI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SWE', 'Sweden', 'Europe', 'Nordic Countries', 449964.00, 836, 8861400, 79.6, 226492.00, 227757.00, 'Sverige', 'Constitutional Monarchy', 'Carl XVI Gustaf', 3048, 'SE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SWZ', 'Swaziland', 'Africa', 'Southern Africa', 17364.00, 1968, 1008000, 40.4, 1206.00, 1312.00, 'kaNgwane', 'Monarchy', 'Mswati III', 3244, 'SZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SYC', 'Seychelles', 'Africa', 'Eastern Africa', 455.00, 1976, 77000, 70.4, 536.00, 539.00, 'Sesel/Seychelles', 'Republic', 'France-Albert René', 3206, 'SC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('SYR', 'Syria', 'Asia', 'Middle East', 185180.00, 1941, 16125000, 68.5, 65984.00, 64926.00, 'Suriya', 'Republic', 'Bashar al-Assad', 3250, 'SY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TCA', 'Turks and Caicos Islands', 'North America', 'Caribbean', 430.00, NULL, 17000, 73.3, 96.00, NULL, 'The Turks and Caicos Islands', 'Dependent Territory of the UK', 'Elisabeth II', 3423, 'TC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TCD', 'Chad', 'Africa', 'Central Africa', 1284000.00, 1960, 7651000, 50.5, 1208.00, 1102.00, 'Tchad/Tshad', 'Republic', 'Idriss Déby', 3337, 'TD');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TGO', 'Togo', 'Africa', 'Western Africa', 56785.00, 1960, 4629000, 54.7, 1449.00, 1400.00, 'Togo', 'Republic', 'Gnassingbé Eyadéma', 3332, 'TG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('THA', 'Thailand', 'Asia', 'Southeast Asia', 513115.00, 1350, 61399000, 68.6, 116416.00, 153907.00, 'Prathet Thai', 'Constitutional Monarchy', 'Bhumibol Adulyadej', 3320, 'TH');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TJK', 'Tajikistan', 'Asia', 'Southern and Central Asia', 143100.00, 1991, 6188000, 64.1, 1990.00, 1056.00, 'Toçikiston', 'Republic', 'Emomali Rahmonov', 3261, 'TJ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TKL', 'Tokelau', 'Oceania', 'Polynesia', 12.00, NULL, 2000, NULL, 0.00, NULL, 'Tokelau', 'Nonmetropolitan Territory of New Zealand', 'Elisabeth II', 3333, 'TK');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TKM', 'Turkmenistan', 'Asia', 'Southern and Central Asia', 488100.00, 1991, 4459000, 60.9, 4397.00, 2000.00, 'Türkmenostan', 'Republic', 'Saparmurad Nijazov', 3419, 'TM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TMP', 'East Timor', 'Asia', 'Southeast Asia', 14874.00, NULL, 885000, 46.0, 0.00, NULL, 'Timor Timur', 'Administrated by the UN', 'José Alexandre Gusmão', 1522, 'TP');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TON', 'Tonga', 'Oceania', 'Polynesia', 650.00, 1970, 99000, 67.9, 146.00, 170.00, 'Tonga', 'Monarchy', 'Taufa''ahau Tupou IV', 3334, 'TO');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TTO', 'Trinidad and Tobago', 'North America', 'Caribbean', 5130.00, 1962, 1295000, 68.0, 6232.00, 5867.00, 'Trinidad and Tobago', 'Republic', 'Arthur N. R. Robinson', 3336, 'TT');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TUN', 'Tunisia', 'Africa', 'Northern Africa', 163610.00, 1956, 9586000, 73.7, 20026.00, 18898.00, 'Tunis/Tunisie', 'Republic', 'Zine al-Abidine Ben Ali', 3349, 'TN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TUR', 'Turkey', 'Asia', 'Middle East', 774815.00, 1923, 66591000, 71.0, 210721.00, 189122.00, 'Türkiye', 'Republic', 'Ahmet Necdet Sezer', 3358, 'TR');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TUV', 'Tuvalu', 'Oceania', 'Polynesia', 26.00, 1978, 12000, 66.3, 6.00, NULL, 'Tuvalu', 'Constitutional Monarchy', 'Elisabeth II', 3424, 'TV');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TWN', 'Taiwan', 'Asia', 'Eastern Asia', 36188.00, 1945, 22256000, 76.4, 256254.00, 263451.00, 'T’ai-wan', 'Republic', 'Chen Shui-bian', 3263, 'TW');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('TZA', 'Tanzania', 'Africa', 'Eastern Africa', 883749.00, 1961, 33517000, 52.3, 8005.00, 7388.00, 'Tanzania', 'Republic', 'Benjamin William Mkapa', 3306, 'TZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('UGA', 'Uganda', 'Africa', 'Eastern Africa', 241038.00, 1962, 21778000, 42.9, 6313.00, 6887.00, 'Uganda', 'Republic', 'Yoweri Museveni', 3425, 'UG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('UKR', 'Ukraine', 'Europe', 'Eastern Europe', 603700.00, 1991, 50456000, 66.0, 42168.00, 49677.00, 'Ukrajina', 'Republic', 'Leonid Kutšma', 3426, 'UA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('UMI', 'United States Minor Outlying Islands', 'Oceania', 'Micronesia/Caribbean', 16.00, NULL, 0, NULL, 0.00, NULL, 'United States Minor Outlying Islands', 'Dependent Territory of the US', 'George W. Bush', NULL, 'UM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('URY', 'Uruguay', 'South America', 'South America', 175016.00, 1828, 3337000, 75.2, 20831.00, 19967.00, 'Uruguay', 'Republic', 'Jorge Batlle Ibáñez', 3492, 'UY');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('USA', 'United States', 'North America', 'North America', 9363520.00, 1776, 278357000, 77.1, 8510700.00, 8110900.00, 'United States', 'Federal Republic', 'George W. Bush', 3813, 'US');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('UZB', 'Uzbekistan', 'Asia', 'Southern and Central Asia', 447400.00, 1991, 24318000, 63.7, 14194.00, 21300.00, 'Uzbekiston', 'Republic', 'Islam Karimov', 3503, 'UZ');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VAT', 'Holy See (Vatican City State)', 'Europe', 'Southern Europe', 0.40, 1929, 1000, NULL, 9.00, NULL, 'Santa Sede/Città del Vaticano', 'Independent Church State', 'Johannes Paavali II', 3538, 'VA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VCT', 'Saint Vincent and the Grenadines', 'North America', 'Caribbean', 388.00, 1979, 114000, 72.3, 285.00, NULL, 'Saint Vincent and the Grenadines', 'Constitutional Monarchy', 'Elisabeth II', 3066, 'VC');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VEN', 'Venezuela', 'South America', 'South America', 912050.00, 1811, 24170000, 73.1, 95023.00, 88434.00, 'Venezuela', 'Federal Republic', 'Hugo Chávez Frías', 3539, 'VE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VGB', 'Virgin Islands, British', 'North America', 'Caribbean', 151.00, NULL, 21000, 75.4, 612.00, 573.00, 'British Virgin Islands', 'Dependent Territory of the UK', 'Elisabeth II', 537, 'VG');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VIR', 'Virgin Islands, U.S.', 'North America', 'Caribbean', 347.00, NULL, 93000, 78.1, 0.00, NULL, 'Virgin Islands of the United States', 'US Territory', 'George W. Bush', 4067, 'VI');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VNM', 'Vietnam', 'Asia', 'Southeast Asia', 331689.00, 1945, 79832000, 69.3, 21929.00, 22834.00, 'Viêt Nam', 'Socialistic Republic', 'Trân Duc Luong', 3770, 'VN');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('VUT', 'Vanuatu', 'Oceania', 'Melanesia', 12189.00, 1980, 190000, 60.6, 261.00, 246.00, 'Vanuatu', 'Republic', 'John Bani', 3537, 'VU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('WLF', 'Wallis and Futuna', 'Oceania', 'Polynesia', 200.00, NULL, 15000, NULL, 0.00, NULL, 'Wallis-et-Futuna', 'Nonmetropolitan Territory of France', 'Jacques Chirac', 3536, 'WF');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('WSM', 'Samoa', 'Oceania', 'Polynesia', 2831.00, 1962, 180000, 69.2, 141.00, 157.00, 'Samoa', 'Parlementary Monarchy', 'Malietoa Tanumafili II', 3169, 'WS');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('YEM', 'Yemen', 'Asia', 'Middle East', 527968.00, 1918, 18112000, 59.8, 6041.00, 5729.00, 'Al-Yaman', 'Republic', 'Ali Abdallah Salih', 1780, 'YE');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('YUG', 'Yugoslavia', 'Europe', 'Southern Europe', 102173.00, 1918, 10640000, 72.4, 17000.00, NULL, 'Jugoslavija', 'Federal Republic', 'Vojislav Koštunica', 1792, 'YU');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ZAF', 'South Africa', 'Africa', 'Southern Africa', 1221037.00, 1910, 40377000, 51.1, 116729.00, 129092.00, 'South Africa', 'Republic', 'Thabo Mbeki', 716, 'ZA');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ZMB', 'Zambia', 'Africa', 'Eastern Africa', 752618.00, 1964, 9169000, 37.2, 3377.00, 3922.00, 'Zambia', 'Republic', 'Frederick Chiluba', 3162, 'ZM');
INSERT INTO `country` (`Code`,`Name`,`Continent`,`Region`,`SurfaceArea`,`IndepYear`,`Population`,`LifeExpectancy`,`GNP`,`GNPOld`,`LocalName`,`GovernmentForm`,`HeadOfState`,`Capital`,`Code2`) VALUES ('ZWE', 'Zimbabwe', 'Africa', 'Eastern Africa', 390757.00, 1980, 11669000, 37.8, 5951.00, 8670.00, 'Zimbabwe', 'Republic', 'Robert G. Mugabe', 4068, 'ZW');

INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (10, 'Cardiology');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (8, 'Dental');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (6, 'Diagnostic');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (3, 'Emergency');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (1, 'General Outpatient');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (4, 'Maternity');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (9, 'Orthopedic');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (7, 'Pediatric');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (2, 'Specialist Clinic');
INSERT INTO `clinic_types` (`id`,`type_name`) VALUES (5, 'Surgical');

INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (1, 'Kabul', 'AFG', 'Kabol', 1780000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (2, 'Qandahar', 'AFG', 'Qandahar', 237500, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (3, 'Herat', 'AFG', 'Herat', 186800, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (4, 'Mazar-e-Sharif', 'AFG', 'Balkh', 127800, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (5, 'Amsterdam', 'NLD', 'Noord-Holland', 731200, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (6, 'Rotterdam', 'NLD', 'Zuid-Holland', 593321, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (7, 'Haag', 'NLD', 'Zuid-Holland', 440900, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (8, 'Utrecht', 'NLD', 'Utrecht', 234323, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (9, 'Eindhoven', 'NLD', 'Noord-Brabant', 201843, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (10, 'Tilburg', 'NLD', 'Noord-Brabant', 193238, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (11, 'Groningen', 'NLD', 'Groningen', 172701, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (12, 'Breda', 'NLD', 'Noord-Brabant', 160398, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (13, 'Apeldoorn', 'NLD', 'Gelderland', 153491, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (14, 'Nijmegen', 'NLD', 'Gelderland', 152463, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (15, 'Enschede', 'NLD', 'Overijssel', 149544, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (16, 'Haarlem', 'NLD', 'Noord-Holland', 148772, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (17, 'Almere', 'NLD', 'Flevoland', 142465, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (18, 'Arnhem', 'NLD', 'Gelderland', 138020, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (19, 'Zaanstad', 'NLD', 'Noord-Holland', 135621, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (20, '´s-Hertogenbosch', 'NLD', 'Noord-Brabant', 129170, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (21, 'Amersfoort', 'NLD', 'Utrecht', 126270, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (22, 'Maastricht', 'NLD', 'Limburg', 122087, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (23, 'Dordrecht', 'NLD', 'Zuid-Holland', 119811, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (24, 'Leiden', 'NLD', 'Zuid-Holland', 117196, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (25, 'Haarlemmermeer', 'NLD', 'Noord-Holland', 110722, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (26, 'Zoetermeer', 'NLD', 'Zuid-Holland', 110214, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (27, 'Emmen', 'NLD', 'Drenthe', 105853, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (28, 'Zwolle', 'NLD', 'Overijssel', 105819, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (29, 'Ede', 'NLD', 'Gelderland', 101574, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (30, 'Delft', 'NLD', 'Zuid-Holland', 95268, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (31, 'Heerlen', 'NLD', 'Limburg', 95052, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (32, 'Alkmaar', 'NLD', 'Noord-Holland', 92713, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (33, 'Willemstad', 'ANT', 'Curaçao', 2345, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (34, 'Tirana', 'ALB', 'Tirana', 270000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (35, 'Alger', 'DZA', 'Alger', 2168000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (36, 'Oran', 'DZA', 'Oran', 609823, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (37, 'Constantine', 'DZA', 'Constantine', 443727, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (38, 'Annaba', 'DZA', 'Annaba', 222518, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (39, 'Batna', 'DZA', 'Batna', 183377, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (40, 'Sétif', 'DZA', 'Sétif', 179055, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (41, 'Sidi Bel Abbès', 'DZA', 'Sidi Bel Abbès', 153106, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (42, 'Skikda', 'DZA', 'Skikda', 128747, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (43, 'Biskra', 'DZA', 'Biskra', 128281, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (44, 'Blida (el-Boulaida)', 'DZA', 'Blida', 127284, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (45, 'Béjaïa', 'DZA', 'Béjaïa', 117162, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (46, 'Mostaganem', 'DZA', 'Mostaganem', 115212, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (47, 'Tébessa', 'DZA', 'Tébessa', 112007, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (48, 'Tlemcen (Tilimsen)', 'DZA', 'Tlemcen', 110242, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (49, 'Béchar', 'DZA', 'Béchar', 107311, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (50, 'Tiaret', 'DZA', 'Tiaret', 100118, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (51, 'Ech-Chleff (el-Asnam)', 'DZA', 'Chlef', 96794, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (52, 'Ghardaïa', 'DZA', 'Ghardaïa', 89415, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (53, 'Tafuna', 'ASM', 'Tutuila', 5200, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (54, 'Fagatogo', 'ASM', 'Tutuila', 2323, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (55, 'Andorra la Vella', 'AND', 'Andorra la Vella', 21189, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (56, 'Luanda', 'AGO', 'Luanda', 2022000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (57, 'Huambo', 'AGO', 'Huambo', 163100, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (58, 'Lobito', 'AGO', 'Benguela', 130000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (59, 'Benguela', 'AGO', 'Benguela', 128300, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (60, 'Namibe', 'AGO', 'Namibe', 118200, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (61, 'South Hill', 'AIA', '–', 961, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (62, 'The Valley', 'AIA', '–', 595, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (63, 'Saint John´s', 'ATG', 'St John', 24000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (64, 'Dubai', 'ARE', 'Dubai', 669181, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (65, 'Abu Dhabi', 'ARE', 'Abu Dhabi', 398695, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (66, 'Sharja', 'ARE', 'Sharja', 320095, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (67, 'al-Ayn', 'ARE', 'Abu Dhabi', 225970, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (68, 'Ajman', 'ARE', 'Ajman', 114395, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (69, 'Buenos Aires', 'ARG', 'Distrito Federal', 2982146, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (70, 'La Matanza', 'ARG', 'Buenos Aires', 1266461, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (71, 'Córdoba', 'ARG', 'Córdoba', 1157507, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (72, 'Rosario', 'ARG', 'Santa Fé', 907718, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (73, 'Lomas de Zamora', 'ARG', 'Buenos Aires', 622013, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (74, 'Quilmes', 'ARG', 'Buenos Aires', 559249, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (75, 'Almirante Brown', 'ARG', 'Buenos Aires', 538918, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (76, 'La Plata', 'ARG', 'Buenos Aires', 521936, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (77, 'Mar del Plata', 'ARG', 'Buenos Aires', 512880, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (78, 'San Miguel de Tucumán', 'ARG', 'Tucumán', 470809, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (79, 'Lanús', 'ARG', 'Buenos Aires', 469735, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (80, 'Merlo', 'ARG', 'Buenos Aires', 463846, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (81, 'General San Martín', 'ARG', 'Buenos Aires', 422542, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (82, 'Salta', 'ARG', 'Salta', 367550, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (83, 'Moreno', 'ARG', 'Buenos Aires', 356993, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (84, 'Santa Fé', 'ARG', 'Santa Fé', 353063, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (85, 'Avellaneda', 'ARG', 'Buenos Aires', 353046, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (86, 'Tres de Febrero', 'ARG', 'Buenos Aires', 352311, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (87, 'Morón', 'ARG', 'Buenos Aires', 349246, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (88, 'Florencio Varela', 'ARG', 'Buenos Aires', 315432, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (89, 'San Isidro', 'ARG', 'Buenos Aires', 306341, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (90, 'Tigre', 'ARG', 'Buenos Aires', 296226, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (91, 'Malvinas Argentinas', 'ARG', 'Buenos Aires', 290335, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (92, 'Vicente López', 'ARG', 'Buenos Aires', 288341, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (93, 'Berazategui', 'ARG', 'Buenos Aires', 276916, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (94, 'Corrientes', 'ARG', 'Corrientes', 258103, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (95, 'San Miguel', 'ARG', 'Buenos Aires', 248700, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (96, 'Bahía Blanca', 'ARG', 'Buenos Aires', 239810, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (97, 'Esteban Echeverría', 'ARG', 'Buenos Aires', 235760, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (98, 'Resistencia', 'ARG', 'Chaco', 229212, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (99, 'José C. Paz', 'ARG', 'Buenos Aires', 221754, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (100, 'Paraná', 'ARG', 'Entre Rios', 207041, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (101, 'Godoy Cruz', 'ARG', 'Mendoza', 206998, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (102, 'Posadas', 'ARG', 'Misiones', 201273, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (103, 'Guaymallén', 'ARG', 'Mendoza', 200595, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (104, 'Santiago del Estero', 'ARG', 'Santiago del Estero', 189947, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (105, 'San Salvador de Jujuy', 'ARG', 'Jujuy', 178748, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (106, 'Hurlingham', 'ARG', 'Buenos Aires', 170028, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (107, 'Neuquén', 'ARG', 'Neuquén', 167296, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (108, 'Ituzaingó', 'ARG', 'Buenos Aires', 158197, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (109, 'San Fernando', 'ARG', 'Buenos Aires', 153036, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (110, 'Formosa', 'ARG', 'Formosa', 147636, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (111, 'Las Heras', 'ARG', 'Mendoza', 145823, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (112, 'La Rioja', 'ARG', 'La Rioja', 138117, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (113, 'San Fernando del Valle de Cata', 'ARG', 'Catamarca', 134935, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (114, 'Río Cuarto', 'ARG', 'Córdoba', 134355, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (115, 'Comodoro Rivadavia', 'ARG', 'Chubut', 124104, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (116, 'Mendoza', 'ARG', 'Mendoza', 123027, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (117, 'San Nicolás de los Arroyos', 'ARG', 'Buenos Aires', 119302, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (118, 'San Juan', 'ARG', 'San Juan', 119152, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (119, 'Escobar', 'ARG', 'Buenos Aires', 116675, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (120, 'Concordia', 'ARG', 'Entre Rios', 116485, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (121, 'Pilar', 'ARG', 'Buenos Aires', 113428, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (122, 'San Luis', 'ARG', 'San Luis', 110136, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (123, 'Ezeiza', 'ARG', 'Buenos Aires', 99578, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (124, 'San Rafael', 'ARG', 'Mendoza', 94651, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (125, 'Tandil', 'ARG', 'Buenos Aires', 91101, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (126, 'Yerevan', 'ARM', 'Yerevan', 1248700, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (127, 'Gjumri', 'ARM', 'Širak', 211700, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (128, 'Vanadzor', 'ARM', 'Lori', 172700, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (129, 'Oranjestad', 'ABW', '–', 29034, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (130, 'Sydney', 'AUS', 'New South Wales', 3276207, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (131, 'Melbourne', 'AUS', 'Victoria', 2865329, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (132, 'Brisbane', 'AUS', 'Queensland', 1291117, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (133, 'Perth', 'AUS', 'West Australia', 1096829, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (134, 'Adelaide', 'AUS', 'South Australia', 978100, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (135, 'Canberra', 'AUS', 'Capital Region', 322723, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (136, 'Gold Coast', 'AUS', 'Queensland', 311932, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (137, 'Newcastle', 'AUS', 'New South Wales', 270324, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (138, 'Central Coast', 'AUS', 'New South Wales', 227657, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (139, 'Wollongong', 'AUS', 'New South Wales', 219761, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (140, 'Hobart', 'AUS', 'Tasmania', 126118, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (141, 'Geelong', 'AUS', 'Victoria', 125382, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (142, 'Townsville', 'AUS', 'Queensland', 109914, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (143, 'Cairns', 'AUS', 'Queensland', 92273, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (144, 'Bakı', 'AZE', 'Bakı', 1787800, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (145, 'Gəncə', 'AZE', 'Gəncə', 299300, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (146, 'Sumqayıt', 'AZE', 'Sumqayıt', 283000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (147, 'Mingəçevir', 'AZE', 'Mingəçevir', 93900, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (148, 'Nassau', 'BHS', 'New Providence', 172000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (149, 'al-Manama', 'BHR', 'al-Manama', 148000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (150, 'Dhaka', 'BGD', 'Dhaka', 3612850, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (151, 'Chittagong', 'BGD', 'Chittagong', 1392860, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (152, 'Khulna', 'BGD', 'Khulna', 663340, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (153, 'Rajshahi', 'BGD', 'Rajshahi', 294056, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (154, 'Narayanganj', 'BGD', 'Dhaka', 202134, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (155, 'Rangpur', 'BGD', 'Rajshahi', 191398, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (156, 'Mymensingh', 'BGD', 'Dhaka', 188713, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (157, 'Barisal', 'BGD', 'Barisal', 170232, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (158, 'Tungi', 'BGD', 'Dhaka', 168702, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (159, 'Jessore', 'BGD', 'Khulna', 139710, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (160, 'Comilla', 'BGD', 'Chittagong', 135313, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (161, 'Nawabganj', 'BGD', 'Rajshahi', 130577, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (162, 'Dinajpur', 'BGD', 'Rajshahi', 127815, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (163, 'Bogra', 'BGD', 'Rajshahi', 120170, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (164, 'Sylhet', 'BGD', 'Sylhet', 117396, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (165, 'Brahmanbaria', 'BGD', 'Chittagong', 109032, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (166, 'Tangail', 'BGD', 'Dhaka', 106004, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (167, 'Jamalpur', 'BGD', 'Dhaka', 103556, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (168, 'Pabna', 'BGD', 'Rajshahi', 103277, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (169, 'Naogaon', 'BGD', 'Rajshahi', 101266, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (170, 'Sirajganj', 'BGD', 'Rajshahi', 99669, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (171, 'Narsinghdi', 'BGD', 'Dhaka', 98342, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (172, 'Saidpur', 'BGD', 'Rajshahi', 96777, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (173, 'Gazipur', 'BGD', 'Dhaka', 96717, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (174, 'Bridgetown', 'BRB', 'St Michael', 6070, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (175, 'Antwerpen', 'BEL', 'Antwerpen', 446525, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (176, 'Gent', 'BEL', 'East Flanderi', 224180, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (177, 'Charleroi', 'BEL', 'Hainaut', 200827, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (178, 'Liège', 'BEL', 'Liège', 185639, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (179, 'Bruxelles [Brussel]', 'BEL', 'Bryssel', 133859, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (180, 'Brugge', 'BEL', 'West Flanderi', 116246, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (181, 'Schaerbeek', 'BEL', 'Bryssel', 105692, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (182, 'Namur', 'BEL', 'Namur', 105419, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (183, 'Mons', 'BEL', 'Hainaut', 90935, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (184, 'Belize City', 'BLZ', 'Belize City', 55810, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (185, 'Belmopan', 'BLZ', 'Cayo', 7105, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (186, 'Cotonou', 'BEN', 'Atlantique', 536827, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (187, 'Porto-Novo', 'BEN', 'Ouémé', 194000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (188, 'Djougou', 'BEN', 'Atacora', 134099, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (189, 'Parakou', 'BEN', 'Borgou', 103577, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (190, 'Saint George', 'BMU', 'Saint George´s', 1800, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (191, 'Hamilton', 'BMU', 'Hamilton', 1200, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (192, 'Thimphu', 'BTN', 'Thimphu', 22000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (193, 'Santa Cruz de la Sierra', 'BOL', 'Santa Cruz', 935361, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (194, 'La Paz', 'BOL', 'La Paz', 758141, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (195, 'El Alto', 'BOL', 'La Paz', 534466, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (196, 'Cochabamba', 'BOL', 'Cochabamba', 482800, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (197, 'Oruro', 'BOL', 'Oruro', 223553, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (198, 'Sucre', 'BOL', 'Chuquisaca', 178426, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (199, 'Potosí', 'BOL', 'Potosí', 140642, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (200, 'Tarija', 'BOL', 'Tarija', 125255, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (201, 'Sarajevo', 'BIH', 'Federaatio', 360000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (202, 'Banja Luka', 'BIH', 'Republika Srpska', 143079, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (203, 'Zenica', 'BIH', 'Federaatio', 96027, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (204, 'Gaborone', 'BWA', 'Gaborone', 213017, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (205, 'Francistown', 'BWA', 'Francistown', 101805, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (206, 'São Paulo', 'BRA', 'São Paulo', 9968485, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (207, 'Rio de Janeiro', 'BRA', 'Rio de Janeiro', 5598953, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (208, 'Salvador', 'BRA', 'Bahia', 2302832, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (209, 'Belo Horizonte', 'BRA', 'Minas Gerais', 2139125, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (210, 'Fortaleza', 'BRA', 'Ceará', 2097757, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (211, 'Brasília', 'BRA', 'Distrito Federal', 1969868, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (212, 'Curitiba', 'BRA', 'Paraná', 1584232, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (213, 'Recife', 'BRA', 'Pernambuco', 1378087, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (214, 'Porto Alegre', 'BRA', 'Rio Grande do Sul', 1314032, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (215, 'Manaus', 'BRA', 'Amazonas', 1255049, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (216, 'Belém', 'BRA', 'Pará', 1186926, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (217, 'Guarulhos', 'BRA', 'São Paulo', 1095874, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (218, 'Goiânia', 'BRA', 'Goiás', 1056330, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (219, 'Campinas', 'BRA', 'São Paulo', 950043, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (220, 'São Gonçalo', 'BRA', 'Rio de Janeiro', 869254, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (221, 'Nova Iguaçu', 'BRA', 'Rio de Janeiro', 862225, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (222, 'São Luís', 'BRA', 'Maranhão', 837588, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (223, 'Maceió', 'BRA', 'Alagoas', 786288, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (224, 'Duque de Caxias', 'BRA', 'Rio de Janeiro', 746758, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (225, 'São Bernardo do Campo', 'BRA', 'São Paulo', 723132, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (226, 'Teresina', 'BRA', 'Piauí', 691942, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (227, 'Natal', 'BRA', 'Rio Grande do Norte', 688955, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (228, 'Osasco', 'BRA', 'São Paulo', 659604, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (229, 'Campo Grande', 'BRA', 'Mato Grosso do Sul', 649593, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (230, 'Santo André', 'BRA', 'São Paulo', 630073, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (231, 'João Pessoa', 'BRA', 'Paraíba', 584029, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (232, 'Jaboatão dos Guararapes', 'BRA', 'Pernambuco', 558680, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (233, 'Contagem', 'BRA', 'Minas Gerais', 520801, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (234, 'São José dos Campos', 'BRA', 'São Paulo', 515553, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (235, 'Uberlândia', 'BRA', 'Minas Gerais', 487222, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (236, 'Feira de Santana', 'BRA', 'Bahia', 479992, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (237, 'Ribeirão Preto', 'BRA', 'São Paulo', 473276, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (238, 'Sorocaba', 'BRA', 'São Paulo', 466823, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (239, 'Niterói', 'BRA', 'Rio de Janeiro', 459884, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (240, 'Cuiabá', 'BRA', 'Mato Grosso', 453813, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (241, 'Juiz de Fora', 'BRA', 'Minas Gerais', 450288, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (242, 'Aracaju', 'BRA', 'Sergipe', 445555, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (243, 'São João de Meriti', 'BRA', 'Rio de Janeiro', 440052, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (244, 'Londrina', 'BRA', 'Paraná', 432257, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (245, 'Joinville', 'BRA', 'Santa Catarina', 428011, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (246, 'Belford Roxo', 'BRA', 'Rio de Janeiro', 425194, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (247, 'Santos', 'BRA', 'São Paulo', 408748, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (248, 'Ananindeua', 'BRA', 'Pará', 400940, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (249, 'Campos dos Goytacazes', 'BRA', 'Rio de Janeiro', 398418, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (250, 'Mauá', 'BRA', 'São Paulo', 375055, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (251, 'Carapicuíba', 'BRA', 'São Paulo', 357552, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (252, 'Olinda', 'BRA', 'Pernambuco', 354732, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (253, 'Campina Grande', 'BRA', 'Paraíba', 352497, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (254, 'São José do Rio Preto', 'BRA', 'São Paulo', 351944, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (255, 'Caxias do Sul', 'BRA', 'Rio Grande do Sul', 349581, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (256, 'Moji das Cruzes', 'BRA', 'São Paulo', 339194, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (257, 'Diadema', 'BRA', 'São Paulo', 335078, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (258, 'Aparecida de Goiânia', 'BRA', 'Goiás', 324662, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (259, 'Piracicaba', 'BRA', 'São Paulo', 319104, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (260, 'Cariacica', 'BRA', 'Espírito Santo', 319033, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (261, 'Vila Velha', 'BRA', 'Espírito Santo', 318758, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (262, 'Pelotas', 'BRA', 'Rio Grande do Sul', 315415, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (263, 'Bauru', 'BRA', 'São Paulo', 313670, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (264, 'Porto Velho', 'BRA', 'Rondônia', 309750, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (265, 'Serra', 'BRA', 'Espírito Santo', 302666, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (266, 'Betim', 'BRA', 'Minas Gerais', 302108, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (267, 'Jundíaí', 'BRA', 'São Paulo', 296127, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (268, 'Canoas', 'BRA', 'Rio Grande do Sul', 294125, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (269, 'Franca', 'BRA', 'São Paulo', 290139, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (270, 'São Vicente', 'BRA', 'São Paulo', 286848, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (271, 'Maringá', 'BRA', 'Paraná', 286461, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (272, 'Montes Claros', 'BRA', 'Minas Gerais', 286058, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (273, 'Anápolis', 'BRA', 'Goiás', 282197, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (274, 'Florianópolis', 'BRA', 'Santa Catarina', 281928, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (275, 'Petrópolis', 'BRA', 'Rio de Janeiro', 279183, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (276, 'Itaquaquecetuba', 'BRA', 'São Paulo', 270874, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (277, 'Vitória', 'BRA', 'Espírito Santo', 270626, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (278, 'Ponta Grossa', 'BRA', 'Paraná', 268013, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (279, 'Rio Branco', 'BRA', 'Acre', 259537, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (280, 'Foz do Iguaçu', 'BRA', 'Paraná', 259425, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (281, 'Macapá', 'BRA', 'Amapá', 256033, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (282, 'Ilhéus', 'BRA', 'Bahia', 254970, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (283, 'Vitória da Conquista', 'BRA', 'Bahia', 253587, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (284, 'Uberaba', 'BRA', 'Minas Gerais', 249225, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (285, 'Paulista', 'BRA', 'Pernambuco', 248473, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (286, 'Limeira', 'BRA', 'São Paulo', 245497, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (287, 'Blumenau', 'BRA', 'Santa Catarina', 244379, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (288, 'Caruaru', 'BRA', 'Pernambuco', 244247, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (289, 'Santarém', 'BRA', 'Pará', 241771, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (290, 'Volta Redonda', 'BRA', 'Rio de Janeiro', 240315, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (291, 'Novo Hamburgo', 'BRA', 'Rio Grande do Sul', 239940, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (292, 'Caucaia', 'BRA', 'Ceará', 238738, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (293, 'Santa Maria', 'BRA', 'Rio Grande do Sul', 238473, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (294, 'Cascavel', 'BRA', 'Paraná', 237510, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (295, 'Guarujá', 'BRA', 'São Paulo', 237206, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (296, 'Ribeirão das Neves', 'BRA', 'Minas Gerais', 232685, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (297, 'Governador Valadares', 'BRA', 'Minas Gerais', 231724, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (298, 'Taubaté', 'BRA', 'São Paulo', 229130, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (299, 'Imperatriz', 'BRA', 'Maranhão', 224564, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (300, 'Gravataí', 'BRA', 'Rio Grande do Sul', 223011, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (301, 'Embu', 'BRA', 'São Paulo', 222223, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (302, 'Mossoró', 'BRA', 'Rio Grande do Norte', 214901, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (303, 'Várzea Grande', 'BRA', 'Mato Grosso', 214435, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (304, 'Petrolina', 'BRA', 'Pernambuco', 210540, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (305, 'Barueri', 'BRA', 'São Paulo', 208426, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (306, 'Viamão', 'BRA', 'Rio Grande do Sul', 207557, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (307, 'Ipatinga', 'BRA', 'Minas Gerais', 206338, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (308, 'Juazeiro', 'BRA', 'Bahia', 201073, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (309, 'Juazeiro do Norte', 'BRA', 'Ceará', 199636, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (310, 'Taboão da Serra', 'BRA', 'São Paulo', 197550, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (311, 'São José dos Pinhais', 'BRA', 'Paraná', 196884, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (312, 'Magé', 'BRA', 'Rio de Janeiro', 196147, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (313, 'Suzano', 'BRA', 'São Paulo', 195434, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (314, 'São Leopoldo', 'BRA', 'Rio Grande do Sul', 189258, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (315, 'Marília', 'BRA', 'São Paulo', 188691, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (316, 'São Carlos', 'BRA', 'São Paulo', 187122, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (317, 'Sumaré', 'BRA', 'São Paulo', 186205, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (318, 'Presidente Prudente', 'BRA', 'São Paulo', 185340, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (319, 'Divinópolis', 'BRA', 'Minas Gerais', 185047, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (320, 'Sete Lagoas', 'BRA', 'Minas Gerais', 182984, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (321, 'Rio Grande', 'BRA', 'Rio Grande do Sul', 182222, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (322, 'Itabuna', 'BRA', 'Bahia', 182148, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (323, 'Jequié', 'BRA', 'Bahia', 179128, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (324, 'Arapiraca', 'BRA', 'Alagoas', 178988, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (325, 'Colombo', 'BRA', 'Paraná', 177764, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (326, 'Americana', 'BRA', 'São Paulo', 177409, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (327, 'Alvorada', 'BRA', 'Rio Grande do Sul', 175574, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (328, 'Araraquara', 'BRA', 'São Paulo', 174381, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (329, 'Itaboraí', 'BRA', 'Rio de Janeiro', 173977, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (330, 'Santa Bárbara d´Oeste', 'BRA', 'São Paulo', 171657, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (331, 'Nova Friburgo', 'BRA', 'Rio de Janeiro', 170697, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (332, 'Jacareí', 'BRA', 'São Paulo', 170356, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (333, 'Araçatuba', 'BRA', 'São Paulo', 169303, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (334, 'Barra Mansa', 'BRA', 'Rio de Janeiro', 168953, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (335, 'Praia Grande', 'BRA', 'São Paulo', 168434, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (336, 'Marabá', 'BRA', 'Pará', 167795, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (337, 'Criciúma', 'BRA', 'Santa Catarina', 167661, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (338, 'Boa Vista', 'BRA', 'Roraima', 167185, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (339, 'Passo Fundo', 'BRA', 'Rio Grande do Sul', 166343, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (340, 'Dourados', 'BRA', 'Mato Grosso do Sul', 164716, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (341, 'Santa Luzia', 'BRA', 'Minas Gerais', 164704, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (342, 'Rio Claro', 'BRA', 'São Paulo', 163551, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (343, 'Maracanaú', 'BRA', 'Ceará', 162022, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (344, 'Guarapuava', 'BRA', 'Paraná', 160510, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (345, 'Rondonópolis', 'BRA', 'Mato Grosso', 155115, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (346, 'São José', 'BRA', 'Santa Catarina', 155105, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (347, 'Cachoeiro de Itapemirim', 'BRA', 'Espírito Santo', 155024, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (348, 'Nilópolis', 'BRA', 'Rio de Janeiro', 153383, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (349, 'Itapevi', 'BRA', 'São Paulo', 150664, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (350, 'Cabo de Santo Agostinho', 'BRA', 'Pernambuco', 149964, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (351, 'Camaçari', 'BRA', 'Bahia', 149146, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (352, 'Sobral', 'BRA', 'Ceará', 146005, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (353, 'Itajaí', 'BRA', 'Santa Catarina', 145197, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (354, 'Chapecó', 'BRA', 'Santa Catarina', 144158, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (355, 'Cotia', 'BRA', 'São Paulo', 140042, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (356, 'Lages', 'BRA', 'Santa Catarina', 139570, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (357, 'Ferraz de Vasconcelos', 'BRA', 'São Paulo', 139283, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (358, 'Indaiatuba', 'BRA', 'São Paulo', 135968, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (359, 'Hortolândia', 'BRA', 'São Paulo', 135755, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (360, 'Caxias', 'BRA', 'Maranhão', 133980, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (361, 'São Caetano do Sul', 'BRA', 'São Paulo', 133321, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (362, 'Itu', 'BRA', 'São Paulo', 132736, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (363, 'Nossa Senhora do Socorro', 'BRA', 'Sergipe', 131351, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (364, 'Parnaíba', 'BRA', 'Piauí', 129756, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (365, 'Poços de Caldas', 'BRA', 'Minas Gerais', 129683, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (366, 'Teresópolis', 'BRA', 'Rio de Janeiro', 128079, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (367, 'Barreiras', 'BRA', 'Bahia', 127801, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (368, 'Castanhal', 'BRA', 'Pará', 127634, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (369, 'Alagoinhas', 'BRA', 'Bahia', 126820, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (370, 'Itapecerica da Serra', 'BRA', 'São Paulo', 126672, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (371, 'Uruguaiana', 'BRA', 'Rio Grande do Sul', 126305, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (372, 'Paranaguá', 'BRA', 'Paraná', 126076, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (373, 'Ibirité', 'BRA', 'Minas Gerais', 125982, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (374, 'Timon', 'BRA', 'Maranhão', 125812, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (375, 'Luziânia', 'BRA', 'Goiás', 125597, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (376, 'Macaé', 'BRA', 'Rio de Janeiro', 125597, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (377, 'Teófilo Otoni', 'BRA', 'Minas Gerais', 124489, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (378, 'Moji-Guaçu', 'BRA', 'São Paulo', 123782, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (379, 'Palmas', 'BRA', 'Tocantins', 121919, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (380, 'Pindamonhangaba', 'BRA', 'São Paulo', 121904, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (381, 'Francisco Morato', 'BRA', 'São Paulo', 121197, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (382, 'Bagé', 'BRA', 'Rio Grande do Sul', 120793, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (383, 'Sapucaia do Sul', 'BRA', 'Rio Grande do Sul', 120217, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (384, 'Cabo Frio', 'BRA', 'Rio de Janeiro', 119503, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (385, 'Itapetininga', 'BRA', 'São Paulo', 119391, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (386, 'Patos de Minas', 'BRA', 'Minas Gerais', 119262, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (387, 'Camaragibe', 'BRA', 'Pernambuco', 118968, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (388, 'Bragança Paulista', 'BRA', 'São Paulo', 116929, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (389, 'Queimados', 'BRA', 'Rio de Janeiro', 115020, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (390, 'Araguaína', 'BRA', 'Tocantins', 114948, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (391, 'Garanhuns', 'BRA', 'Pernambuco', 114603, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (392, 'Vitória de Santo Antão', 'BRA', 'Pernambuco', 113595, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (393, 'Santa Rita', 'BRA', 'Paraíba', 113135, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (394, 'Barbacena', 'BRA', 'Minas Gerais', 113079, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (395, 'Abaetetuba', 'BRA', 'Pará', 111258, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (396, 'Jaú', 'BRA', 'São Paulo', 109965, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (397, 'Lauro de Freitas', 'BRA', 'Bahia', 109236, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (398, 'Franco da Rocha', 'BRA', 'São Paulo', 108964, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (399, 'Teixeira de Freitas', 'BRA', 'Bahia', 108441, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (400, 'Varginha', 'BRA', 'Minas Gerais', 108314, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (401, 'Ribeirão Pires', 'BRA', 'São Paulo', 108121, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (402, 'Sabará', 'BRA', 'Minas Gerais', 107781, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (403, 'Catanduva', 'BRA', 'São Paulo', 107761, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (404, 'Rio Verde', 'BRA', 'Goiás', 107755, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (405, 'Botucatu', 'BRA', 'São Paulo', 107663, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (406, 'Colatina', 'BRA', 'Espírito Santo', 107354, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (407, 'Santa Cruz do Sul', 'BRA', 'Rio Grande do Sul', 106734, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (408, 'Linhares', 'BRA', 'Espírito Santo', 106278, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (409, 'Apucarana', 'BRA', 'Paraná', 105114, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (410, 'Barretos', 'BRA', 'São Paulo', 104156, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (411, 'Guaratinguetá', 'BRA', 'São Paulo', 103433, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (412, 'Cachoeirinha', 'BRA', 'Rio Grande do Sul', 103240, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (413, 'Codó', 'BRA', 'Maranhão', 103153, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (414, 'Jaraguá do Sul', 'BRA', 'Santa Catarina', 102580, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (415, 'Cubatão', 'BRA', 'São Paulo', 102372, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (416, 'Itabira', 'BRA', 'Minas Gerais', 102217, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (417, 'Itaituba', 'BRA', 'Pará', 101320, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (418, 'Araras', 'BRA', 'São Paulo', 101046, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (419, 'Resende', 'BRA', 'Rio de Janeiro', 100627, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (420, 'Atibaia', 'BRA', 'São Paulo', 100356, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (421, 'Pouso Alegre', 'BRA', 'Minas Gerais', 100028, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (422, 'Toledo', 'BRA', 'Paraná', 99387, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (423, 'Crato', 'BRA', 'Ceará', 98965, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (424, 'Passos', 'BRA', 'Minas Gerais', 98570, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (425, 'Araguari', 'BRA', 'Minas Gerais', 98399, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (426, 'São José de Ribamar', 'BRA', 'Maranhão', 98318, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (427, 'Pinhais', 'BRA', 'Paraná', 98198, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (428, 'Sertãozinho', 'BRA', 'São Paulo', 98140, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (429, 'Conselheiro Lafaiete', 'BRA', 'Minas Gerais', 97507, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (430, 'Paulo Afonso', 'BRA', 'Bahia', 97291, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (431, 'Angra dos Reis', 'BRA', 'Rio de Janeiro', 96864, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (432, 'Eunápolis', 'BRA', 'Bahia', 96610, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (433, 'Salto', 'BRA', 'São Paulo', 96348, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (434, 'Ourinhos', 'BRA', 'São Paulo', 96291, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (435, 'Parnamirim', 'BRA', 'Rio Grande do Norte', 96210, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (436, 'Jacobina', 'BRA', 'Bahia', 96131, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (437, 'Coronel Fabriciano', 'BRA', 'Minas Gerais', 95933, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (438, 'Birigui', 'BRA', 'São Paulo', 94685, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (439, 'Tatuí', 'BRA', 'São Paulo', 93897, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (440, 'Ji-Paraná', 'BRA', 'Rondônia', 93346, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (441, 'Bacabal', 'BRA', 'Maranhão', 93121, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (442, 'Cametá', 'BRA', 'Pará', 92779, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (443, 'Guaíba', 'BRA', 'Rio Grande do Sul', 92224, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (444, 'São Lourenço da Mata', 'BRA', 'Pernambuco', 91999, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (445, 'Santana do Livramento', 'BRA', 'Rio Grande do Sul', 91779, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (446, 'Votorantim', 'BRA', 'São Paulo', 91777, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (447, 'Campo Largo', 'BRA', 'Paraná', 91203, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (448, 'Patos', 'BRA', 'Paraíba', 90519, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (449, 'Ituiutaba', 'BRA', 'Minas Gerais', 90507, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (450, 'Corumbá', 'BRA', 'Mato Grosso do Sul', 90111, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (451, 'Palhoça', 'BRA', 'Santa Catarina', 89465, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (452, 'Barra do Piraí', 'BRA', 'Rio de Janeiro', 89388, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (453, 'Bento Gonçalves', 'BRA', 'Rio Grande do Sul', 89254, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (454, 'Poá', 'BRA', 'São Paulo', 89236, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (455, 'Águas Lindas de Goiás', 'BRA', 'Goiás', 89200, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (456, 'London', 'GBR', 'England', 7285000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (457, 'Birmingham', 'GBR', 'England', 1013000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (458, 'Glasgow', 'GBR', 'Scotland', 619680, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (459, 'Liverpool', 'GBR', 'England', 461000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (460, 'Edinburgh', 'GBR', 'Scotland', 450180, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (461, 'Sheffield', 'GBR', 'England', 431607, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (462, 'Manchester', 'GBR', 'England', 430000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (463, 'Leeds', 'GBR', 'England', 424194, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (464, 'Bristol', 'GBR', 'England', 402000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (465, 'Cardiff', 'GBR', 'Wales', 321000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (466, 'Coventry', 'GBR', 'England', 304000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (467, 'Leicester', 'GBR', 'England', 294000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (468, 'Bradford', 'GBR', 'England', 289376, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (469, 'Belfast', 'GBR', 'North Ireland', 287500, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (470, 'Nottingham', 'GBR', 'England', 287000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (471, 'Kingston upon Hull', 'GBR', 'England', 262000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (472, 'Plymouth', 'GBR', 'England', 253000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (473, 'Stoke-on-Trent', 'GBR', 'England', 252000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (474, 'Wolverhampton', 'GBR', 'England', 242000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (475, 'Derby', 'GBR', 'England', 236000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (476, 'Swansea', 'GBR', 'Wales', 230000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (477, 'Southampton', 'GBR', 'England', 216000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (478, 'Aberdeen', 'GBR', 'Scotland', 213070, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (479, 'Northampton', 'GBR', 'England', 196000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (480, 'Dudley', 'GBR', 'England', 192171, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (481, 'Portsmouth', 'GBR', 'England', 190000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (482, 'Newcastle upon Tyne', 'GBR', 'England', 189150, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (483, 'Sunderland', 'GBR', 'England', 183310, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (484, 'Luton', 'GBR', 'England', 183000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (485, 'Swindon', 'GBR', 'England', 180000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (486, 'Southend-on-Sea', 'GBR', 'England', 176000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (487, 'Walsall', 'GBR', 'England', 174739, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (488, 'Bournemouth', 'GBR', 'England', 162000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (489, 'Peterborough', 'GBR', 'England', 156000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (490, 'Brighton', 'GBR', 'England', 156124, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (491, 'Blackpool', 'GBR', 'England', 151000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (492, 'Dundee', 'GBR', 'Scotland', 146690, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (493, 'West Bromwich', 'GBR', 'England', 146386, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (494, 'Reading', 'GBR', 'England', 148000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (495, 'Oldbury/Smethwick (Warley)', 'GBR', 'England', 145542, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (496, 'Middlesbrough', 'GBR', 'England', 145000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (497, 'Huddersfield', 'GBR', 'England', 143726, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (498, 'Oxford', 'GBR', 'England', 144000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (499, 'Poole', 'GBR', 'England', 141000, NULL);
INSERT INTO `city` (`ID`,`Name`,`CountryCode`,`District`,`Population`,`country_code`) VALUES (500, 'Bolton', 'GBR', 'England', 139020, NULL);

INSERT INTO `next_of_kin` (`id`,`patient_id`,`full_name`,`relationship`,`phone`,`email`,`address`,`is_primary`,`next_of_kin_status_id`,`created_at`) VALUES (3, 50, 'isah isah', 'son', '07064163237', 'adbullahij@gmail.com', 'federal university teaching  hospital, Lafia', 0, 1, '2026-03-25 15:39:33');

INSERT INTO `next_of_kin_statuses` (`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`) VALUES (1, 'Active', 'Next of kin currently active and valid', 1, '2026-03-25 12:35:45', '2026-03-25 12:35:45');
INSERT INTO `next_of_kin_statuses` (`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`) VALUES (2, 'Inactive', 'Next of kin no longer active', 1, '2026-03-25 12:35:45', '2026-03-25 12:35:45');
INSERT INTO `next_of_kin_statuses` (`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`) VALUES (3, 'Suspended', 'Temporarily disabled', 1, '2026-03-25 12:35:45', '2026-03-25 12:35:45');
INSERT INTO `next_of_kin_statuses` (`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`) VALUES (4, 'Deceased', 'Next of kin is deceased', 1, '2026-03-25 12:35:45', '2026-03-25 12:35:45');
INSERT INTO `next_of_kin_statuses` (`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`) VALUES (5, 'Blocked', 'Not allowed to be contacted', 1, '2026-03-25 12:35:45', '2026-03-25 12:35:45');

INSERT INTO `patient_vitals` (`id`,`encounter_id`,`temperature`,`weight`,`height`,`blood_pressure`,`pulse`,`respiration`,`spo2`,`bmi`,`recorded_by`,`recorded_at`) VALUES (1, 1, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 10, NULL);

INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (1, 'Consultation', 'Doctor consultation services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (2, 'Laboratory', 'Medical laboratory tests', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (3, 'Radiology', 'Imaging and scan services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (4, 'Pharmacy', 'Drug dispensing and medications', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (5, 'Surgery', 'Surgical procedures', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (6, 'Nursing', 'Nursing care services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (7, 'Emergency', 'Emergency care services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (8, 'Physiotherapy', 'Physical therapy services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (9, 'Dental', 'Dental care services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (10, 'Ophthalmology', 'Eye care services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (11, 'Cardiology', 'Heart-related services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (12, 'Maternity', 'Pregnancy and delivery services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (13, 'Immunization', 'Vaccination services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (14, 'Dialysis', 'Kidney dialysis services', 1);
INSERT INTO `service_categories` (`id`,`name`,`description`,`is_active`) VALUES (15, 'Endoscopy', 'Internal examination procedures', 1);

INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (42, '7787', 'Muhammad', 'Shuaibu Umar', 'Male', '1975-04-12 01:00:00', '08065550005', 'muhdsumar@gmail.com', 'Ahmadu Bello University, Zaria', 'Zaria', 'Kanuri', 'Islam', 'Civil Servant', 'Ahmadu Bello University, Zaria', 'In-patient', '2026-03-16 01:00:00', 1, NULL, NULL, NULL, NULL);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (43, '607691', 'Jibril', 'Abdullahi', 'Male', '1996-05-05 01:00:00', '07064163237', 'abdullahij@gmail.com', 'no.31 Abuja Street, Lafia, Nasarawa ', 'Lafia', 'taken', 'Islam', 'civil Servant', 'FGN', 'NHIS', '2026-03-12 01:00:00', 4, NULL, NULL, NULL, NULL);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (44, 'HSP1001', 'Abdullahi', 'Musa', 'Male', '1990-05-14 01:00:00', '08034567891', 'musa.abdullahi@example.com', '12 Emir Road Kano', 'Kano', 'Hausa', 'Islam', 'Trader', 'Kano Central Market', 'Out-patient', '2026-03-17 11:20:08', 1, 1, 1, 1, 1);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (45, 'HSP1002', 'Okafor', 'Chinedu', 'Male', '1985-09-21 01:00:00', '08045678912', 'chinedu.okafor@example.com', '45 Zaria Road Kaduna', 'Onitsha', 'Igbo', 'Christianity', 'Engineer', 'Tech Nigeria Ltd', 'NHIS', '2026-03-17 11:20:08', 1, 1, 2, 2, 2);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (46, 'HSP1003', 'Adeyemi', 'Bola', 'Female', '1993-11-02 01:00:00', '08056789123', 'bola.adeyemi@example.com', '23 Lagos Street Ibadan', 'Ibadan', 'Yoruba', 'Christianity', 'Teacher', 'Unity School', 'Out-patient', '2026-03-17 11:20:08', 1, 1, 3, 1, 3);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (47, 'HSP1004', 'Garba', 'Aisha', 'Female', '1998-03-17 01:00:00', '08067891234', 'aisha.garba@example.com', '7 Tarauni Layout Kano', 'Kano', 'Hausa', 'Islam', 'Student', 'Bayero University', 'Out-patient', '2026-03-17 11:20:08', 1, 1, 1, 1, 1);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (48, 'HSP1005', 'Danladi', 'Sani', 'Male', '1978-07-11 01:00:00', '08078912345', 'sani.danladi@example.com', '19 Sokoto Road', 'Sokoto', 'Fulani', 'Islam', 'Farmer', 'Self-employed', 'In-patient', '2026-03-17 11:20:08', 1, 1, 4, 2, 2);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (49, 'HSP1006', 'Eze', 'Ngozi', 'Female', '1991-12-30 01:00:00', '08089123456', 'ngozi.eze@example.com', '11 Enugu Lane', 'Enugu', 'Igbo', 'Christianity', 'Nurse', 'General Hospital', 'NHIS', '2026-03-17 11:20:08', 1, 1, 5, 3, 4);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (50, 'HSP1007', 'Yusuf', 'Ibrahim', 'Male', '1987-04-18 01:00:00', '08091234567', 'ibrahim.yusuf@example.com', '5 Katsina Avenue', 'Katsina', 'Hausa', 'Islam', 'Civil Servant', 'State Ministry', 'NASHIA', '2026-03-17 11:20:08', 1, 1, 6, 2, 3);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (51, 'HSP1008', 'Balogun', 'Tunde', 'Male', '1995-08-09 01:00:00', '07012345678', 'tunde.balogun@example.com', '17 Abeokuta Street', 'Abeokuta', 'Yoruba', 'Christianity', 'Driver', 'ABC Transport', 'Out-patient', '2026-03-17 11:20:08', 1, 1, 7, 1, 2);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (52, 'HSP1009', 'Lawal', 'Fatima', 'Female', '2000-01-25 01:00:00', '07023456789', 'fatima.lawal@example.com', '10 Maiduguri Road', 'Maiduguri', 'Kanuri', 'Islam', 'Tailor', 'Self-employed', 'Out-patient', '2026-03-17 11:20:08', 1, 1, 8, 1, 5);
INSERT INTO `patients` (`id`,`hospital_number`,`surname`,`first_name`,`sex`,`dob`,`phone`,`email`,`address`,`place_of_birth`,`tribe`,`religion`,`occupation`,`employer`,`patient_type`,`created_at`,`hospital_id`,`country_id`,`city_id`,`insurance_plan_id`,`district_id`) VALUES (53, 'HSP1010', 'Ojo', 'Samuel', 'Male', '1982-10-05 01:00:00', '07034567890', 'samuel.ojo@example.com', '8 Akure Close', 'Akure', 'Yoruba', 'Christianity', 'Banker', 'First Bank', 'NHIS', '2026-03-17 11:20:08', 1, 1, 9, 2, 4);

INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (1, 'Clinical Services', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (2, 'Laboratory', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (3, 'Pharmacy', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (4, 'Administrative', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (5, 'Account', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (6, 'Support', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (7, 'Operations', NULL, NULL);
INSERT INTO `departments` (`id`,`name`,`description`,`head_user_id`) VALUES (8, 'Auditing', NULL, NULL);

INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (1, 'Cardiology', 'Heart related treatments', NULL, 1);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (2, 'General Ward', 'General patient care and recovery', NULL, 1);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (3, 'Emergency Room', 'Immediate critical care services', NULL, 1);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (4, 'Maternity', 'Childbirth and neonatal care', NULL, 1);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (5, 'Surgery', 'Operative procedures and surgeries', NULL, 1);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (6, 'Haematology', 'Blood analysis and testing', NULL, 2);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (7, 'Microbiology', 'Bacteria and virus identification', NULL, 2);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (8, 'Biochemistry', 'Chemical analysis of bodily fluids', NULL, 2);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (9, 'Histopathology', 'Tissue examination for diagnosis', NULL, 2);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (10, 'Outpatient Pharmacy', 'Medication dispensing for outpatients', NULL, 3);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (11, 'Inpatient Pharmacy', 'Ward-based medication supply', NULL, 3);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (12, 'Oncology Pharmacy', 'Specialized cancer drugs', NULL, 3);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (13, 'Drug Inventory', 'Stock management and storage', NULL, 3);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (14, 'Human Resources', 'Staff recruitment and welfare', NULL, 4);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (15, 'Medical Records', 'Patient file archiving and data', NULL, 4);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (16, 'Executive Office', 'Hospital management and leadership', NULL, 4);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (17, 'Reception', 'Front desk and patient registration', NULL, 4);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (18, 'Billing', 'Patient invoicing and payments', NULL, 5);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (19, 'Payroll', 'Employee salary processing', NULL, 5);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (20, 'Budget & Finance', 'Financial planning and audits', NULL, 5);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (21, 'Insurance', 'Claims processing and verification', NULL, 5);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (22, 'Housekeeping', 'Cleaning and sanitation services', NULL, 6);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (23, 'Security', 'Premises safety and access control', NULL, 6);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (24, 'Maintenance', 'Equipment and facility repairs', NULL, 6);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (25, 'Catering', 'Patient and staff meal services', NULL, 6);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (26, 'Logistics', 'Transport and supply delivery', NULL, 7);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (27, 'Procurement', 'Purchasing of supplies and equipment', NULL, 7);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (28, 'Sterilization', 'Central sterile services department', NULL, 7);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (29, 'Internal Audit', 'Internal compliance checks', NULL, 8);
INSERT INTO `units` (`id`,`name`,`description`,`head_user_id`,`department_id`) VALUES (30, 'Risk Management', 'Operational risk assessment', NULL, 8);

INSERT INTO `discharge_types` (`id`,`name`,`is_active`) VALUES (1, 'Home', 1);
INSERT INTO `discharge_types` (`id`,`name`,`is_active`) VALUES (2, 'Transfer', 1);
INSERT INTO `discharge_types` (`id`,`name`,`is_active`) VALUES (3, 'Against Medical Advice', 1);
INSERT INTO `discharge_types` (`id`,`name`,`is_active`) VALUES (4, 'Absconded', 1);
INSERT INTO `discharge_types` (`id`,`name`,`is_active`) VALUES (5, 'Deceased', 1);

INSERT INTO `temporary_patient_statuses` (`id`,`name`,`is_active`) VALUES (1, 'Waiting', 1);
INSERT INTO `temporary_patient_statuses` (`id`,`name`,`is_active`) VALUES (2, 'Seen', 1);
INSERT INTO `temporary_patient_statuses` (`id`,`name`,`is_active`) VALUES (3, 'Admitted', 1);
INSERT INTO `temporary_patient_statuses` (`id`,`name`,`is_active`) VALUES (4, 'Converted', 1);
INSERT INTO `temporary_patient_statuses` (`id`,`name`,`is_active`) VALUES (5, 'Cancelled', 1);


ALTER TABLE `users`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `users`
ADD FOREIGN KEY ( `role_id` )
REFERENCES `roles` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `users`
ADD FOREIGN KEY ( `unit_id` )
REFERENCES `units` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `theatres`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `appointments`
ADD FOREIGN KEY ( `clinic_id` )
REFERENCES `clinics` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `appointments`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `appointments`
ADD FOREIGN KEY ( `doctor_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `encounters`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `encounters`
ADD FOREIGN KEY ( `doctor_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `encounters`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `medical_procedures`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `medical_procedures`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `medical_procedures`
ADD FOREIGN KEY ( `performed_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `ecg_investigations`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `clinics`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `clinics`
ADD FOREIGN KEY ( `clinic_type_id` )
REFERENCES `clinic_types` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `city`
ADD FOREIGN KEY ( `CountryCode` )
REFERENCES `country` ( `Code` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `city`
ADD FOREIGN KEY ( `country_code` )
REFERENCES `country` ( `Code` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `next_of_kin`
ADD FOREIGN KEY ( `next_of_kin_status_id` )
REFERENCES `next_of_kin_statuses` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `next_of_kin`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `og_followups`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `patient_vitals`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `patient_vitals`
ADD FOREIGN KEY ( `recorded_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `patient_services`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `patient_services`
ADD FOREIGN KEY ( `service_id` )
REFERENCES `services` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `referral_status_history`
ADD FOREIGN KEY ( `referral_id` )
REFERENCES `referrals` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `referral_status_history`
ADD FOREIGN KEY ( `updated_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `referral_documents`
ADD FOREIGN KEY ( `referral_id` )
REFERENCES `referrals` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `referral_documents`
ADD FOREIGN KEY ( `uploaded_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `referral_feedback`
ADD FOREIGN KEY ( `referral_id` )
REFERENCES `referrals` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `referral_feedback`
ADD FOREIGN KEY ( `receiving_doctor_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `prescriptions`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `prescriptions`
ADD FOREIGN KEY ( `prescribed_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `prescription_items`
ADD FOREIGN KEY ( `prescription_id` )
REFERENCES `prescriptions` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `prescription_items`
ADD FOREIGN KEY ( `drug_id` )
REFERENCES `drugs` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `referrals`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `referral_type_id` )
REFERENCES `referral_types` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `referring_doctor_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `from_facility_id` )
REFERENCES `facilities` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `to_facility_id` )
REFERENCES `facilities` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `referrals`
ADD FOREIGN KEY ( `to_department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `wards`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `ticket_replies`
ADD FOREIGN KEY ( `ticket_id` )
REFERENCES `support_tickets` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `ticket_replies`
ADD FOREIGN KEY ( `user_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `surgery_schedules`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `surgery_schedules`
ADD FOREIGN KEY ( `theatre_id` )
REFERENCES `theatres` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `surgery_schedules`
ADD FOREIGN KEY ( `surgeon_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `support_tickets`
ADD FOREIGN KEY ( `assigned_to` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `support_tickets`
ADD FOREIGN KEY ( `user_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `states`
ADD FOREIGN KEY ( `country_id` )
REFERENCES `countries` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `services`
ADD FOREIGN KEY ( `category_id` )
REFERENCES `service_categories` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `service_prices`
ADD FOREIGN KEY ( `service_id` )
REFERENCES `services` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `rooms`
ADD FOREIGN KEY ( `ward_id` )
REFERENCES `wards` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `residents`
ADD FOREIGN KEY ( `user_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `residents`
ADD FOREIGN KEY ( `program_id` )
REFERENCES `residency_programs` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `research_projects`
ADD FOREIGN KEY ( `principal_investigator` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `residency_programs`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `academic_departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `refunds`
ADD FOREIGN KEY ( `approved_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `refunds`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `refunds`
ADD FOREIGN KEY ( `payment_id` )
REFERENCES `payments` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `nashia_enrollments`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `nashia_enrollments`
ADD FOREIGN KEY ( `plan_id` )
REFERENCES `insurance_plans` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;
ALTER TABLE `nashia_enrollments`
ADD FOREIGN KEY ( `provider_id` )
REFERENCES `insurance_providers` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `mortuary_records`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `messages`
ADD FOREIGN KEY ( `receiver_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `messages`
ADD FOREIGN KEY ( `sender_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `medical_records`
ADD FOREIGN KEY ( `appointment_id` )
REFERENCES `appointments` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `medical_records`
ADD FOREIGN KEY ( `clinic_id` )
REFERENCES `clinics` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `medical_records`
ADD FOREIGN KEY ( `doctor_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;
ALTER TABLE `medical_records`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `nhis_enrollments`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `nhis_enrollments`
ADD FOREIGN KEY ( `plan_id` )
REFERENCES `insurance_plans` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;
ALTER TABLE `nhis_enrollments`
ADD FOREIGN KEY ( `provider_id` )
REFERENCES `insurance_providers` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `patient_feedback`
ADD FOREIGN KEY ( `clinic_id` )
REFERENCES `clinics` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;
ALTER TABLE `patient_feedback`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `patient_feedback`
ADD FOREIGN KEY ( `medical_record_id` )
REFERENCES `medical_records` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `patient_insurance`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `patient_insurance`
ADD FOREIGN KEY ( `plan_id` )
REFERENCES `insurance_plans` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `payments`
ADD FOREIGN KEY ( `payment_method_id` )
REFERENCES `payment_methods` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `payments`
ADD FOREIGN KEY ( `paid_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `academic_departments`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `audit_logs`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `audit_logs`
ADD FOREIGN KEY ( `user_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `beds`
ADD FOREIGN KEY ( `room_id` )
REFERENCES `rooms` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `beds`
ADD FOREIGN KEY ( `current_patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `blood_inventory`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `capitation_payments`
ADD FOREIGN KEY ( `provider_id` )
REFERENCES `insurance_providers` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `chart_of_accounts`
ADD FOREIGN KEY ( `parent_id` )
REFERENCES `chart_of_accounts` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `chart_of_accounts`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `medical_equipment`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `invoices`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `invoices`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `icu_beds`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `insurance_authorizations`
ADD FOREIGN KEY ( `patient_insurance_id` )
REFERENCES `patient_insurance` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_authorizations`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_authorizations`
ADD FOREIGN KEY ( `requested_service_id` )
REFERENCES `services` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `insurance_claims`
ADD FOREIGN KEY ( `patient_insurance_id` )
REFERENCES `patient_insurance` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_claims`
ADD FOREIGN KEY ( `encounter_id` )
REFERENCES `encounters` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_claims`
ADD FOREIGN KEY ( `invoice_id` )
REFERENCES `invoices` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_claims`
ADD FOREIGN KEY ( `referral_id` )
REFERENCES `referrals` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `insurance_payments`
ADD FOREIGN KEY ( `claim_id` )
REFERENCES `insurance_claims` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_payments`
ADD FOREIGN KEY ( `received_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `insurance_plans`
ADD FOREIGN KEY ( `provider_id` )
REFERENCES `insurance_providers` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `insurance_tariffs`
ADD FOREIGN KEY ( `plan_id` )
REFERENCES `insurance_plans` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `insurance_tariffs`
ADD FOREIGN KEY ( `service_id` )
REFERENCES `services` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `inventory_movements`
ADD FOREIGN KEY ( `drug_id` )
REFERENCES `drugs` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `inventory_movements`
ADD FOREIGN KEY ( `batch_id` )
REFERENCES `drug_batches` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `invoice_items`
ADD FOREIGN KEY ( `invoice_id` )
REFERENCES `invoices` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `journal_entries`
ADD FOREIGN KEY ( `hospital_id` )
REFERENCES `hospitals` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;
ALTER TABLE `journal_entries`
ADD FOREIGN KEY ( `created_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `journal_entry_lines`
ADD FOREIGN KEY ( `journal_entry_id` )
REFERENCES `journal_entries` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `journal_entry_lines`
ADD FOREIGN KEY ( `account_id` )
REFERENCES `chart_of_accounts` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `lab_investigations`
ADD FOREIGN KEY ( `patient_id` )
REFERENCES `patients` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `lab_report_results`
ADD FOREIGN KEY ( `report_id` )
REFERENCES `lab_reports` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `lab_reports`
ADD FOREIGN KEY ( `investigation_id` )
REFERENCES `lab_investigations` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `units`
ADD FOREIGN KEY ( `department_id` )
REFERENCES `departments` ( `id` )
ON UPDATE NO ACTION
ON DELETE NO ACTION
;

ALTER TABLE `feedback_responses`
ADD FOREIGN KEY ( `feedback_id` )
REFERENCES `patient_feedback` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `feedback_responses`
ADD FOREIGN KEY ( `admin_id` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE RESTRICT
;

ALTER TABLE `dispensations`
ADD FOREIGN KEY ( `prescription_item_id` )
REFERENCES `prescription_items` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `dispensations`
ADD FOREIGN KEY ( `batch_id` )
REFERENCES `drug_batches` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `dispensations`
ADD FOREIGN KEY ( `dispensed_by` )
REFERENCES `users` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `drugs`
ADD FOREIGN KEY ( `category_id` )
REFERENCES `drug_categories` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `drug_batches`
ADD FOREIGN KEY ( `drug_id` )
REFERENCES `drugs` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;
ALTER TABLE `drug_batches`
ADD FOREIGN KEY ( `supplier_id` )
REFERENCES `suppliers` ( `id` )
ON UPDATE NO ACTION
ON DELETE SET NULL
;

ALTER TABLE `lgas`
ADD FOREIGN KEY ( `state_id` )
REFERENCES `states` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

ALTER TABLE `investigation_results`
ADD FOREIGN KEY ( `investigation_id` )
REFERENCES `investigations` ( `id` )
ON UPDATE NO ACTION
ON DELETE CASCADE
;

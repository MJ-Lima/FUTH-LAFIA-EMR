<?php

namespace App\Filament\Pages;

use App\Models\{
    Admission, Appointment, Bed, BloodDonation, BloodUnit, Budget,
    ChartOfAccount, Department, Diagnosis, Drug, DrugBatch, Encounter,
    ExpenseClaim, InsuranceClaim, Invoice, JournalEntry, LabOrder,
    LeaveRequest, Patient, Payment, Prescription, Procedure,
    ProcedureBooking, RadiologyOrder, Service, Staff, User, Ward
};
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\DB;

class ReportsDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Reports Dashboard';

    protected static ?int $navigationSort = 0;

    protected string $view = 'filament.pages.reports-dashboard';

    protected function getViewData(): array
    {
        return [
            'user'              => auth()->user(),
            'patientStats'      => $this->patientStats(),
            'encounterStats'    => $this->encounterStats(),
            'financialStats'    => $this->financialStats(),
            'pharmacyStats'     => $this->pharmacyStats(),
            'labStats'          => $this->labStats(),
            'radiologyStats'    => $this->radiologyStats(),
            'insuranceStats'    => $this->insuranceStats(),
            'wardStats'         => $this->wardStats(),
            'bloodBankStats'    => $this->bloodBankStats(),
            'procedureStats'    => $this->procedureStats(),
            'auditStats'        => $this->auditStats(),
            'hrStats'           => $this->hrStats(),
            'departmentStats'   => $this->departmentStats(),
            'userStats'         => $this->userStats(),
            'monthlyTrends'     => $this->monthlyTrends(),
        ];
    }

    private function patientStats(): array
    {
        return [
            'total'               => Patient::count(),
            'male'                => Patient::where('gender', 'male')->count(),
            'female'              => Patient::where('gender', 'female')->count(),
            'new_this_month'      => Patient::whereMonth('created_at', now()->month)->count(),
            'new_this_year'       => Patient::whereYear('created_at', now()->year)->count(),
            'verified'            => Patient::where('verification_status', 'Verified')->count(),
            'pending_verification'=> Patient::where('verification_status', 'Pending')->count(),
        ];
    }

    private function encounterStats(): array
    {
        $today = now()->toDateString();
        return [
            'total'        => Encounter::count(),
            'today'        => Encounter::whereDate('encounter_date', $today)->count(),
            'outpatient'   => Encounter::where('visit_type', 'Outpatient')->count(),
            'emergency'    => Encounter::where('visit_type', 'Emergency')->count(),
            'inpatient'    => Encounter::where('visit_type', 'Inpatient')->count(),
            'telemedicine' => Encounter::where('visit_type', 'Telemedicine')->count(),
            'completed'    => Encounter::where('status', 'Completed')->count(),
            'in_progress'  => Encounter::where('status', 'In Progress')->count(),
            'waiting'      => Encounter::where('status', 'Waiting')->count(),
        ];
    }

    private function financialStats(): array
    {
        $today = now()->toDateString();
        $month = now()->month;
        $year  = now()->year;

        return [
            'revenue_today'     => Payment::whereDate('payment_date', $today)->sum('amount'),
            'revenue_month'     => Payment::whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount'),
            'revenue_year'      => Payment::whereYear('payment_date', $year)->sum('amount'),
            'invoices_pending'  => Invoice::whereIn('status', ['Draft', 'Pending'])->count(),
            'invoices_paid'     => Invoice::where('status', 'Paid')->count(),
            'outstanding'       => Invoice::sum('balance_due'),
            'total_assets'      => ChartOfAccount::where('type', 'Asset')->sum('current_balance'),
            'total_liabilities' => ChartOfAccount::where('type', 'Liability')->sum('current_balance'),
            'total_revenue'     => ChartOfAccount::where('type', 'Revenue')->sum('current_balance'),
            'total_expenses'    => ChartOfAccount::where('type', 'Expense')->sum('current_balance'),
            'pending_claims'    => ExpenseClaim::whereIn('status', ['Submitted', 'Under Review'])->count(),
        ];
    }

    private function pharmacyStats(): array
    {
        // Count drugs where total batch stock <= reorder_level
        $lowStockCount = Drug::where('status', true)
            ->whereExists(function ($q) {
                $q->selectRaw('1')
                  ->from('drug_batches')
                  ->whereColumn('drug_batches.drug_id', 'drugs.id')
                  ->where('is_quarantined', false)
                  ->groupBy('drug_batches.drug_id')
                  ->havingRaw('SUM(drug_batches.quantity_remaining) <= drugs.reorder_level');
            })
            ->count();

        return [
            'total_drugs'        => Drug::count(),
            'low_stock'          => $lowStockCount,
            'prescriptions'      => Prescription::count(),
            'pending_dispensing' => Prescription::where('status', 'Pending')->count(),
            'dispensed'          => Prescription::where('status', 'Dispensed')->count(),
        ];
    }

    private function labStats(): array
    {
        return [
            'total_orders' => LabOrder::count(),
            'pending'      => LabOrder::where('status', 'Pending')->count(),
            'in_progress'  => LabOrder::where('status', 'In Progress')->count(),
            'completed'    => LabOrder::where('status', 'Completed')->count(),
            'verified'     => LabOrder::where('status', 'Verified')->count(),
        ];
    }

    private function radiologyStats(): array
    {
        return [
            'total_orders' => RadiologyOrder::count(),
            'pending'      => RadiologyOrder::where('status', 'Pending')->count(),
            'completed'    => RadiologyOrder::where('status', 'Completed')->count(),
            'verified'     => RadiologyOrder::where('status', 'Verified')->count(),
        ];
    }

    private function insuranceStats(): array
    {
        return [
            'providers'        => \App\Models\InsuranceProvider::count(),
            'plans'            => \App\Models\InsurancePlan::count(),
            'active_policies'  => \App\Models\PatientInsurance::where('status', 'Active')->count(),
            'pending_claims'   => InsuranceClaim::whereIn('status', ['Draft', 'Submitted', 'Processing'])->count(),
            'approved_claims'  => InsuranceClaim::where('status', 'Approved')->count(),
            'paid_claims'      => InsuranceClaim::where('status', 'Paid')->count(),
            'pending_pre_auth' => \App\Models\PreAuthorization::where('status', 'Pending')->count(),
        ];
    }

    private function wardStats(): array
    {
        $totalBeds = Bed::count();
        $occupied  = Bed::where('status', 'Occupied')->count();
        return [
            'wards'         => Ward::count(),
            'beds'          => $totalBeds,
            'beds_occupied' => $occupied,
            'beds_available'=> Bed::where('status', 'Available')->count(),
            'admissions'    => Admission::where('status', 'Admitted')->count(),
            'occupancy_pct' => $totalBeds > 0 ? round($occupied / $totalBeds * 100, 1) : 0,
        ];
    }

    private function bloodBankStats(): array
    {
        return [
            'donors'           => \App\Models\BloodDonor::count(),
            'donations'        => BloodDonation::count(),
            'units_available'  => BloodUnit::where('status', 'Available')->count(),
            'units_transfused' => BloodUnit::where('status', 'Transfused')->count(),
            'pending_requests' => \App\Models\BloodRequest::where('status', 'Pending')->count(),
        ];
    }

    private function procedureStats(): array
    {
        return [
            'procedures'         => Procedure::count(),
            'bookings_pending'   => ProcedureBooking::whereIn('booking_status', ['Scheduled', 'Confirmed'])->count(),
            'bookings_completed' => ProcedureBooking::where('booking_status', 'Completed')->count(),
        ];
    }

    private function auditStats(): array
    {
        return [
            'medical_audits'    => \App\Models\MedicalAudit::count(),
            'internal_audits'   => \App\Models\InternalAudit::count(),
            'open_findings'     => \App\Models\MedicalAuditFinding::where('status', 'Open')->count()
                                  + \App\Models\InternalAuditFinding::where('status', 'Open')->count(),
            'critical_findings' => \App\Models\MedicalAuditFinding::where('severity', 'Critical')->count()
                                  + \App\Models\InternalAuditFinding::where('severity', 'Critical')->count(),
        ];
    }

    private function hrStats(): array
    {
        $today = now()->toDateString();
        return [
            'staff'         => Staff::count(),
            'users'         => User::where('status', 'active')->count(),
            'on_leave'      => LeaveRequest::where('status', 'On Leave')
                                  ->where('start_date', '<=', $today)
                                  ->where('end_date', '>=', $today)->count(),
            'pending_leave' => LeaveRequest::where('status', 'Pending')->count(),
        ];
    }

    private function departmentStats(): array
    {
        return Department::withCount(['staff'])->orderBy('name')->limit(15)->get()->map(fn($d) => [
            'name'        => $d->name,
            'code'        => $d->code,
            'staff_count' => $d->staff_count,
        ])->toArray();
    }

    private function userStats(): array
    {
        return User::withCount(['createdEncounters as encounters_count'])
            ->with('roles')
            ->where('status', 'active')
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(fn($u) => [
                'name'             => $u->name,
                'email'            => $u->email,
                'role'             => $u->roles->first()?->name ?? '—',
                'encounters_count' => $u->encounters_count,
                'last_login'       => $u->last_login_at?->diffForHumans() ?? 'Never',
            ])->toArray();
    }

    private function monthlyTrends(): array
    {
        // Use 3 efficient queries instead of 36
        $year = now()->year;
        $months = collect(range(0, 11))->map(fn($i) => now()->subMonths($i));

        $patientCounts = Patient::selectRaw("MONTH(created_at) as m, YEAR(created_at) as y, COUNT(*) as cnt")
            ->whereYear('created_at', '>=', $year - 1)
            ->groupByRaw("YEAR(created_at), MONTH(created_at)")
            ->pluck('cnt', DB::raw("CONCAT(y, '-', LPAD(m, 2, '0'))"))
            ->toArray();

        $encounterCounts = Encounter::selectRaw("MONTH(encounter_date) as m, YEAR(encounter_date) as y, COUNT(*) as cnt")
            ->whereYear('encounter_date', '>=', $year - 1)
            ->groupByRaw("YEAR(encounter_date), MONTH(encounter_date)")
            ->pluck('cnt', DB::raw("CONCAT(y, '-', LPAD(m, 2, '0'))"))
            ->toArray();

        $revenueSums = Payment::selectRaw("MONTH(payment_date) as m, YEAR(payment_date) as y, SUM(amount) as total")
            ->whereYear('payment_date', '>=', $year - 1)
            ->groupByRaw("YEAR(payment_date), MONTH(payment_date)")
            ->pluck('total', DB::raw("CONCAT(y, '-', LPAD(m, 2, '0'))"))
            ->toArray();

        return $months->map(function ($date) use ($patientCounts, $encounterCounts, $revenueSums) {
            $key = $date->format('Y-m');
            return [
                'month'     => $date->format('M Y'),
                'patients'  => $patientCounts[$key] ?? 0,
                'encounters'=> $encounterCounts[$key] ?? 0,
                'revenue'   => $revenueSums[$key] ?? 0,
            ];
        })->reverse()->values()->toArray();
    }

    public function getMaxWidth(): MaxWidth|string
    {
        return MaxWidth::Full;
    }
}
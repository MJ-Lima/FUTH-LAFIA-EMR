<?php

namespace App\Filament\Pages;

use App\Models\{
    Admission, Appointment, Bed, BloodUnit, Budget, ChartOfAccount,
    Department, Diagnosis, Drug, Encounter, ExpenseClaim, InsuranceClaim,
    Invoice, JournalEntry, LabOrder, LeaveRequest, Patient, Payment,
    Prescription, ProcedureBooking, RadiologyOrder, Staff, User, Ward,
    GeneralStoreItem, GeneralStoreStock,
};
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.pages.dashboard';

    protected function getViewData(): array
    {
        $user = auth()->user();
        $role = $user->roles->first()?->name ?? 'Staff';

        return [
            'user'              => $user,
            'role'              => $role,
            'roleBadgeColor'    => $this->resolveRoleBadgeColor($user),
            'dashboardTitle'    => $this->resolveDashboardTitle($role),
            'dashboardSubtitle' => $this->resolveDashboardSubtitle($role),
            'kpiCards'          => $this->resolveKpiCards($user),
            'charts'            => $this->resolveCharts($user),
            'bottomTable'       => $this->resolveBottomTable($user),
            'sideWidgets'       => $this->resolveSideWidgets($user),
            'recentActivities'  => $this->resolveRecentActivities($user),
            'quickActions'      => $this->resolveQuickActions($user),
        ];
    }

    private function resolveRoleBadgeColor(User $user): string
    {
        return match (true) {
            $user->hasRole('Super Admin')              => 'danger',
            $user->hasRole('Medical Administrator')    => 'warning',
            $user->hasRole('Doctor')                   => 'success',
            $user->hasRole('Nurse')                    => 'info',
            $user->hasRole('Pharmacist')               => 'success',
            $user->hasRole('Laboratory Scientist')     => 'info',
            $user->hasRole('Radiographer')             => 'info',
            $user->hasRole('Medical Records Officer')  => 'warning',
            $user->hasRole('Accountant')               => 'warning',
            $user->hasRole('Insurance Officer')        => 'success',
            default                                     => 'gray',
        };
    }

    private function resolveDashboardTitle(string $role): string
    {
        return match($role) {
            'Super Admin'              => 'Administrator Dashboard',
            'Medical Administrator'    => 'Medical Administrator Dashboard',
            'Doctor'                   => 'Doctor Dashboard',
            'Nurse'                    => 'Nursing Dashboard',
            'Pharmacist'               => 'Pharmacy Dashboard',
            'Laboratory Scientist'     => 'Laboratory Dashboard',
            'Radiographer'             => 'Radiology Dashboard',
            'Medical Records Officer'  => 'Record Dashboard',
            'Accountant'               => 'Finance Dashboard',
            'Insurance Officer'        => 'Insurance Dashboard',
            default                     => 'Staff Dashboard',
        };
    }

    private function resolveDashboardSubtitle(string $role): string
    {
        return match($role) {
            'Super Admin'              => 'Overview of all hospital activities and key performance indicators',
            'Medical Administrator'    => 'Overview of hospital operations and clinical performance',
            'Doctor'                   => 'Your patients, encounters, and pending tasks',
            'Nurse'                    => 'Overview of nursing activities and patient care',
            'Pharmacist'               => 'Overview of pharmacy operations and prescriptions',
            'Laboratory Scientist'     => 'Overview of laboratory tests and pending orders',
            'Radiographer'             => 'Overview of radiology imaging and pending orders',
            'Medical Records Officer'  => 'Overview of record department activities and key performance indicators',
            'Accountant'               => 'Overview of financial activities and revenue cycle',
            'Insurance Officer'        => 'Overview of insurance claims and pre-authorizations',
            default                     => 'Your dashboard',
        };
    }

    /**
     * Permission-aware KPI cards — only shows stats the user has permission to view.
     * Each card: label, value, icon, color, change_percent, change_direction
     */
    private function resolveKpiCards(User $user): array
    {
        $cards = [];
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        $lastMonth = now()->subMonth();

        // Total Patients (view_any_patient)
        if ($user->can('view_any_patient')) {
            $total = Patient::count();
            $todayCount = Patient::whereDate('created_at', $today)->count();
            $yesterdayCount = Patient::whereDate('created_at', $yesterday)->count();
            $change = $yesterdayCount > 0 ? round(($todayCount - $yesterdayCount) / $yesterdayCount * 100, 1) : 0;
            $cards[] = ['label' => 'Total Patients', 'value' => number_format($total), 'icon' => 'heroicon-o-users', 'color' => 'blue', 'change' => $change, 'period' => 'vs yesterday'];
        }

        // New Patients (view_any_patient)
        if ($user->can('view_any_patient')) {
            $newThisMonth = Patient::whereMonth('created_at', now()->month)->count();
            $lastMonthCount = Patient::whereMonth('created_at', $lastMonth->month)->count();
            $change = $lastMonthCount > 0 ? round(($newThisMonth - $lastMonthCount) / $lastMonthCount * 100, 1) : 0;
            $cards[] = ['label' => 'New Patients', 'value' => number_format($newThisMonth), 'icon' => 'heroicon-o-user-plus', 'color' => 'purple', 'change' => $change, 'period' => 'vs last month'];
        }

        // Encounters Today (view_any_encounter)
        if ($user->can('view_any_encounter')) {
            $todayEnc = Encounter::whereDate('encounter_date', $today)->count();
            $yesterdayEnc = Encounter::whereDate('encounter_date', $yesterday)->count();
            $change = $yesterdayEnc > 0 ? round(($todayEnc - $yesterdayEnc) / $yesterdayEnc * 100, 1) : 0;
            $cards[] = ['label' => 'Encounters Today', 'value' => number_format($todayEnc), 'icon' => 'heroicon-o-clipboard-document-check', 'color' => 'blue', 'change' => $change, 'period' => 'vs yesterday'];
        }

        // Appointments Today (view_any_appointment)
        if ($user->can('view_any_appointment')) {
            $todayApt = Appointment::whereDate('appointment_date', $today)->count();
            $yesterdayApt = Appointment::whereDate('appointment_date', $yesterday)->count();
            $change = $yesterdayApt > 0 ? round(($todayApt - $yesterdayApt) / $yesterdayApt * 100, 1) : 0;
            $cards[] = ['label' => 'Appointments', 'value' => number_format($todayApt), 'icon' => 'heroicon-o-calendar-days', 'color' => 'purple', 'change' => $change, 'period' => 'today'];
        }

        // Pending Queue (view_any_appointment)
        if ($user->can('view_any_appointment')) {
            $waiting = Appointment::whereDate('appointment_date', $today)->where('status', 'Scheduled')->count();
            $cards[] = ['label' => 'Patient Queue', 'value' => number_format($waiting), 'icon' => 'heroicon-o-clock', 'color' => 'orange', 'change' => 0, 'period' => 'waiting'];
        }

        // Completed Visits (view_any_encounter)
        if ($user->can('view_any_encounter')) {
            $completed = Encounter::whereDate('encounter_date', $today)->where('status', 'Completed')->count();
            $cards[] = ['label' => 'Completed Visits', 'value' => number_format($completed), 'icon' => 'heroicon-o-check-circle', 'color' => 'green', 'change' => 0, 'period' => 'today'];
        }

        // Revenue Today (view_any_payment)
        if ($user->can('view_any_payment')) {
            $revToday = Payment::whereDate('payment_date', $today)->sum('amount');
            $revYesterday = Payment::whereDate('payment_date', $yesterday)->sum('amount');
            $change = $revYesterday > 0 ? round(($revToday - $revYesterday) / $revYesterday * 100, 1) : 0;
            $cards[] = ['label' => 'Revenue Today', 'value' => '₦' . number_format((float)$revToday, 0), 'icon' => 'heroicon-o-banknotes', 'color' => 'green', 'change' => $change, 'period' => 'vs yesterday'];
        }

        // Pending Prescriptions (view_any_prescription)
        if ($user->can('view_any_prescription')) {
            $pendingRx = Prescription::where('status', 'Pending')->count();
            $cards[] = ['label' => 'Pending Rx', 'value' => number_format($pendingRx), 'icon' => 'heroicon-o-document-text', 'color' => 'orange', 'change' => 0, 'period' => 'awaiting dispensing'];
        }

        // Pending Lab Orders (view_any_labOrder)
        if ($user->can('view_any_labOrder')) {
            $pendingLab = LabOrder::where('status', 'Pending')->count();
            $cards[] = ['label' => 'Pending Labs', 'value' => number_format($pendingLab), 'icon' => 'heroicon-o-beaker', 'color' => 'orange', 'change' => 0, 'period' => 'awaiting sample'];
        }

        // Pending Radiology (view_any_radiologyOrder)
        if ($user->can('view_any_radiologyOrder')) {
            $pendingRad = RadiologyOrder::where('status', 'Pending')->count();
            $cards[] = ['label' => 'Pending Radiology', 'value' => number_format($pendingRad), 'icon' => 'heroicon-o-camera', 'color' => 'orange', 'change' => 0, 'period' => 'awaiting scan'];
        }

        // Active Admissions (view_any_admission)
        if ($user->can('view_any_admission')) {
            $activeAdm = Admission::where('status', 'Admitted')->count();
            $cards[] = ['label' => 'Active Admissions', 'value' => number_format($activeAdm), 'icon' => 'heroicon-o-home-modern', 'color' => 'blue', 'change' => 0, 'period' => 'inpatients'];
        }

        // Bed Occupancy (view_any_bed)
        if ($user->can('view_any_bed')) {
            $totalBeds = Bed::count();
            $occupied = Bed::where('status', 'Occupied')->count();
            $occupancyPct = $totalBeds > 0 ? round($occupied / $totalBeds * 100, 1) : 0;
            $cards[] = ['label' => 'Bed Occupancy', 'value' => $occupancyPct . '%', 'icon' => 'heroicon-o-rectangle-stack', 'color' => 'amber', 'change' => 0, 'period' => $occupied . '/' . $totalBeds . ' beds'];
        }

        // Insurance Claims (view_any_insuranceClaim)
        if ($user->can('view_any_insuranceClaim')) {
            $pendingClaims = InsuranceClaim::whereIn('status', ['Submitted', 'Processing'])->count();
            $cards[] = ['label' => 'Insurance Claims', 'value' => number_format($pendingClaims), 'icon' => 'heroicon-o-shield-check', 'color' => 'rose', 'change' => 0, 'period' => 'in processing'];
        }

        // Blood Units Available (view_any_bloodUnit)
        if ($user->can('view_any_bloodUnit')) {
            $bloodAvail = BloodUnit::where('status', 'Available')->count();
            $cards[] = ['label' => 'Blood Units', 'value' => number_format($bloodAvail), 'icon' => 'heroicon-o-heart', 'color' => 'red', 'change' => 0, 'period' => 'available'];
        }

        // Outstanding Invoices (view_any_invoice)
        if ($user->can('view_any_invoice')) {
            $outstanding = Invoice::where('status', '!=', 'Paid')->sum('balance_due');
            $cards[] = ['label' => 'Outstanding', 'value' => '₦' . number_format((float)$outstanding, 0), 'icon' => 'heroicon-o-exclamation-triangle', 'color' => 'red', 'change' => 0, 'period' => 'unpaid invoices'];
        }

        // Staff Count (view_any_staff)
        if ($user->can('view_any_staff')) {
            $staffCount = Staff::count();
            $cards[] = ['label' => 'Staff', 'value' => number_format($staffCount), 'icon' => 'heroicon-o-identification', 'color' => 'indigo', 'change' => 0, 'period' => 'total'];
        }

        return $cards;
    }

    /**
     * Permission-aware charts data
     */
    private function resolveCharts(User $user): array
    {
        $charts = [];

        // Insured vs Private Patients (donut)
        if ($user->can('view_any_patient') && $user->can('view_any_patientInsurance')) {
            $nhia = \App\Models\PatientInsurance::whereHas('provider', fn($q) => $q->where('type', 'NHIA'))->count();
            $private = \App\Models\PatientInsurance::whereHas('provider', fn($q) => $q->where('type', '!=', 'NHIA'))->count();
            $uninsured = Patient::count() - \App\Models\PatientInsurance::count();
            $charts[] = [
                'type' => 'donut',
                'title' => 'Insured vs Private Patients',
                'center_value' => number_format(Patient::count()),
                'center_label' => 'Total',
                'segments' => [
                    ['label' => 'NHIA Patients', 'value' => max(0, $nhia), 'color' => '#8b5cf6'],
                    ['label' => 'Private Insured', 'value' => max(0, $private), 'color' => '#22c55e'],
                    ['label' => 'Uninsured', 'value' => max(0, $uninsured), 'color' => '#3b82f6'],
                ],
            ];
        }

        // Appointment Trend (line chart - last 7 days)
        if ($user->can('view_any_appointment')) {
            $trend = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $scheduled = Appointment::whereDate('appointment_date', $date)->count();
                $completed = Appointment::whereDate('appointment_date', $date)->where('status', 'Completed')->count();
                $trend[] = [
                    'date' => $date->format('M d'),
                    'scheduled' => $scheduled,
                    'completed' => $completed,
                ];
            }
            $charts[] = [
                'type' => 'line',
                'title' => 'Appointment Trend',
                'period' => 'Weekly',
                'data' => $trend,
            ];
        }

        // Queue Overview (donut)
        if ($user->can('view_any_appointment')) {
            $scheduled = Appointment::where('status', 'Scheduled')->count();
            $checkedIn = Appointment::where('status', 'Checked In')->count();
            $completed = Appointment::where('status', 'Completed')->count();
            $noShow = Appointment::where('status', 'No Show')->count();
            $charts[] = [
                'type' => 'donut',
                'title' => 'Queue Overview',
                'center_value' => number_format($scheduled + $checkedIn + $completed + $noShow),
                'center_label' => 'Total',
                'segments' => [
                    ['label' => 'Scheduled', 'value' => $scheduled, 'color' => '#8b5cf6'],
                    ['label' => 'Checked-in', 'value' => $checkedIn, 'color' => '#3b82f6'],
                    ['label' => 'Completed', 'value' => $completed, 'color' => '#22c55e'],
                    ['label' => 'No-show', 'value' => $noShow, 'color' => '#ef4444'],
                ],
            ];
        }

        // Patients by Clinic (horizontal bar)
               // Patients by Clinic (horizontal bar)
        if ($user->can('view_any_patient')) {
            $clinicData = \App\Models\Clinic::withCount(['encounters as patients_count' => function ($q) {
                $q->selectRaw('COUNT(DISTINCT patient_id)');
            }])->orderByDesc('patients_count')->limit(7)->get();
            $charts[] = [
                'type' => 'bar_horizontal',
                'title' => 'Patients by Clinic',
                'period' => 'All Clinics',
                'data' => $clinicData->map(fn($c) => ['label' => $c->name, 'value' => $c->patients_count])->toArray(),
            ];
        }

        // Encounter Types (donut)
        if ($user->can('view_any_encounter')) {
            $outpatient = Encounter::where('visit_type', 'Outpatient')->count();
            $emergency = Encounter::where('visit_type', 'Emergency')->count();
            $inpatient = Encounter::where('visit_type', 'Inpatient')->count();
            $tele = Encounter::where('visit_type', 'Telemedicine')->count();
            $charts[] = [
                'type' => 'donut',
                'title' => 'Encounter Types',
                'center_value' => number_format(Encounter::count()),
                'center_label' => 'Total',
                'segments' => [
                    ['label' => 'Outpatient', 'value' => $outpatient, 'color' => '#22c55e'],
                    ['label' => 'Emergency', 'value' => $emergency, 'color' => '#ef4444'],
                    ['label' => 'Inpatient', 'value' => $inpatient, 'color' => '#f59e0b'],
                    ['label' => 'Telemedicine', 'value' => $tele, 'color' => '#3b82f6'],
                ],
            ];
        }

        // Bed Status (donut)
        if ($user->can('view_any_bed')) {
            $occupied = Bed::where('status', 'Occupied')->count();
            $available = Bed::where('status', 'Available')->count();
            $cleaning = Bed::where('status', 'Cleaning')->count();
            $oos = Bed::where('status', 'Out of Service')->count();
            $charts[] = [
                'type' => 'donut',
                'title' => 'Bed Status',
                'center_value' => number_format(Bed::count()),
                'center_label' => 'Total Beds',
                'segments' => [
                    ['label' => 'Occupied', 'value' => $occupied, 'color' => '#ef4444'],
                    ['label' => 'Available', 'value' => $available, 'color' => '#22c55e'],
                    ['label' => 'Cleaning', 'value' => $cleaning, 'color' => '#f59e0b'],
                    ['label' => 'Out of Service', 'value' => $oos, 'color' => '#6b7280'],
                ],
            ];
        }

        return $charts;
    }

    /**
     * Bottom table — clinic/department performance
     */
    private function resolveBottomTable(User $user): ?array
    {
        if (!$user->can('view_any_encounter')) return null;

        $clinics = \App\Models\Clinic::withCount(['encounters as total_patients' => function($q) {
            $q->whereDate('encounter_date', '>=', now()->subMonth());
        }])->get();

        $rows = [];
        foreach ($clinics as $clinic) {
            $newPatients = Patient::where('created_at', '>=', now()->subMonth())->count();
            $completedEnc = Encounter::where('clinic_id', $clinic->id)->where('status', 'Completed')->whereDate('encounter_date', '>=', now()->subMonth())->count();
            $rows[] = [
                'clinic' => $clinic->name,
                'total_patients' => $clinic->total_patients,
                'new_patients' => $newPatients,
                'avg_wait' => rand(15, 45) . ' mins', // placeholder
                'completed' => $completedEnc,
            ];
        }

        return [
            'title' => 'Clinic Performance',
            'columns' => ['Clinic', 'Total Patients', 'New Patients', 'Avg Wait Time', 'Completed'],
            'rows' => $rows,
        ];
    }

    /**
     * Side widgets — waiting time stats
     */
    private function resolveSideWidgets(User $user): array
    {
        $widgets = [];

        if ($user->can('view_any_appointment')) {
            $widgets[] = [
                'icon' => 'heroicon-o-clock',
                'title' => 'Average Waiting Time',
                'value' => '32 mins',
                'subtitle' => '+8.2% this period',
            ];
            $widgets[] = [
                'icon' => 'heroicon-o-clock',
                'title' => 'Longest Waiting Time',
                'value' => '83 mins',
                'subtitle' => 'Surgery Clinic',
            ];
        }

        if ($user->can('view_any_admission')) {
            $avgStay = Admission::where('status', 'Admitted')->get();
            $avgDays = $avgStay->count() > 0 ? round($avgStay->avg(fn($a) => $a->admission_date?->diffInDays(now())), 1) : 0;
            $widgets[] = [
                'icon' => 'heroicon-o-home-modern',
                'title' => 'Average Length of Stay',
                'value' => $avgDays . ' days',
                'subtitle' => 'current inpatients',
            ];
        }

        if ($user->can('view_any_prescription')) {
            $pending = Prescription::where('status', 'Pending')->count();
            $widgets[] = [
                'icon' => 'heroicon-o-document-text',
                'title' => 'Prescriptions Pending',
                'value' => number_format($pending),
                'subtitle' => 'awaiting dispensing',
            ];
        }

        return $widgets;
    }

    /**
     * Recent activities feed
     */
    private function resolveRecentActivities(User $user): array
    {
        $activities = [];

        if ($user->can('view_any_patient')) {
            $recentPatients = Patient::latest()->limit(3)->get();
            foreach ($recentPatients as $p) {
                $activities[] = [
                    'icon' => 'heroicon-o-user-plus',
                    'event' => 'Patient Registered',
                    'detail' => $p->fullName(),
                    'time' => $p->created_at?->diffForHumans(),
                ];
            }
        }

        if ($user->can('view_any_appointment')) {
            $recentAppts = Appointment::with('patient')->latest()->limit(3)->get();
            foreach ($recentAppts as $a) {
                $activities[] = [
                    'icon' => 'heroicon-o-calendar-days',
                    'event' => 'Appointment Booked',
                    'detail' => $a->patient?->fullName() ?? '—',
                    'time' => $a->created_at?->diffForHumans(),
                ];
            }
        }

        if ($user->can('view_any_encounter')) {
            $recentEnc = Encounter::with('patient')->latest()->limit(2)->get();
            foreach ($recentEnc as $e) {
                $activities[] = [
                    'icon' => 'heroicon-o-clipboard-document-check',
                    'event' => 'Encounter Created',
                    'detail' => $e->patient?->fullName() ?? '—',
                    'time' => $e->created_at?->diffForHumans(),
                ];
            }
        }

        return array_slice($activities, 0, 6);
    }

    private function resolveQuickActions(User $user): array
    {
        $actions = [];
        if ($user->can('create_patient')) $actions[] = ['label' => 'Register Patient', 'url' => '/admin/patients/create', 'icon' => 'heroicon-o-user-plus', 'color' => 'success'];
        if ($user->can('create_encounter')) $actions[] = ['label' => 'New Encounter', 'url' => '/admin/encounters/create', 'icon' => 'heroicon-o-clipboard-document-check', 'color' => 'info'];
        if ($user->can('create_appointment')) $actions[] = ['label' => 'Book Appointment', 'url' => '/admin/appointments/create', 'icon' => 'heroicon-o-calendar-days', 'color' => 'info'];
        if ($user->can('create_prescription')) $actions[] = ['label' => 'New Prescription', 'url' => '/admin/prescriptions/create', 'icon' => 'heroicon-o-document-text', 'color' => 'success'];
        if ($user->can('create_labOrder')) $actions[] = ['label' => 'Lab Order', 'url' => '/admin/lab-orders/create', 'icon' => 'heroicon-o-beaker', 'color' => 'warning'];
        if ($user->can('create_admission')) $actions[] = ['label' => 'Admit Patient', 'url' => '/admin/admissions/create', 'icon' => 'heroicon-o-home-modern', 'color' => 'warning'];
        if ($user->can('create_invoice')) $actions[] = ['label' => 'New Invoice', 'url' => '/admin/invoices/create', 'icon' => 'heroicon-o-document-text', 'color' => 'info'];
        if ($user->can('create_payment')) $actions[] = ['label' => 'Record Payment', 'url' => '/admin/payments/create', 'icon' => 'heroicon-o-banknotes', 'color' => 'success'];
        if ($user->can('create_insuranceClaim')) $actions[] = ['label' => 'Insurance Claim', 'url' => '/admin/insurance-claims/create', 'icon' => 'heroicon-o-shield-check', 'color' => 'success'];
        return $actions;
    }

    public function getMaxWidth(): MaxWidth|string
    {
        return MaxWidth::Full;
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;


use App\Models\Appointment;
use App\Models\DispensingLog;
use App\Models\Encounter;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\RadiologyOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MedicalAdministrationOverview extends BaseWidget
{
    protected  ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $today = today();
        $hospitalId = auth()->user()?->hospital_id;

        $scope = fn ($q) => $q->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId));

        $patientsTotal = Patient::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->count();
        $patientsToday = Patient::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereDate('created_at', $today)->count();

        $encountersToday = Encounter::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereDate('encounter_date', $today)->count();
        $encountersActive = Encounter::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->where('status', 'In Progress')->count();

        $apptsToday = Appointment::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereDate('appointment_date', $today)->count();
        $apptsWaiting = Appointment::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereDate('appointment_date', $today)->whereIn('status', ['Scheduled', 'Confirmed', 'Checked In'])->count();

        $labPending = LabOrder::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereIn('status', ['Pending', 'Sample Collected', 'In Progress'])->count();
        $radPending = RadiologyOrder::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereIn('status', ['Pending', 'Scheduled', 'In Progress'])->count();
        $rxPending = Prescription::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereIn('status', ['Pending', 'Partially Dispensed'])->count();

        $dispensedToday = DispensingLog::query()->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))->whereDate('dispensed_at', $today)->count();

        return [
            Stat::make('Total Patients', number_format($patientsTotal))
                ->description("+{$patientsToday} new today")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->patientTrend()),

            Stat::make("Encounters Today", $encountersToday)
                ->description("{$encountersActive} in progress")
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Appointments Today', $apptsToday)
                ->description("{$apptsWaiting} awaiting consultation")
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('Pending Lab Orders', $labPending)
                ->description('Awaiting results / verification')
                ->descriptionIcon('heroicon-m-beaker')
                ->color($labPending > 10 ? 'danger' : 'gray'),

            Stat::make('Pending Radiology', $radPending)
                ->description('Awaiting scan / report')
                ->descriptionIcon('heroicon-m-viewfinder-circle')
                ->color($radPending > 5 ? 'danger' : 'gray'),

            Stat::make('Pending Prescriptions', $rxPending)
                ->description("{$dispensedToday} dispensed today")
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),
        ];
    }

    private function patientTrend(): array
    {
        $hospitalId = auth()->user()?->hospital_id;
        $days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        return $days->map(fn ($date) => Patient::query()
            ->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))
            ->whereDate('created_at', $date)->count())->toArray();
    }
}

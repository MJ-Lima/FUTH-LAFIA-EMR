<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;


use App\Models\Appointment;
use Filament\Widgets\ChartWidget;

class AppointmentsByStatusChart extends ChartWidget
{
  protected ?string $heading = 'Appointments by Status (last 30 days)';
  protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $hospitalId = auth()->user()?->hospital_id;
        $statuses = ['Scheduled', 'Confirmed', 'Checked In', 'Completed', 'Cancelled', 'No Show'];
        $colors = ['#9ca3af', '#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#dc2626'];

        $data = array_map(fn ($s) => Appointment::query()
            ->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))
            ->where('status', $s)
            ->where('appointment_date', '>=', now()->subDays(30))
            ->count(), $statuses);

        return [
            'datasets' => [[
                'label' => 'Appointments',
                'data' => $data,
                'backgroundColor' => $colors,
            ]],
            'labels' => $statuses,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

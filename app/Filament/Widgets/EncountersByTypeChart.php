<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;
use App\Models\Encounter;
use Filament\Widgets\ChartWidget;

class EncountersByTypeChart extends ChartWidget
{
    protected  ?string $heading = 'Encounters by Visit Type';

    protected  ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $hospitalId = auth()->user()?->hospital_id;
        $types = ['Outpatient', 'Emergency', 'Inpatient', 'Telemedicine', 'Follow-up'];
        $data = array_map(fn ($t) => Encounter::query()
            ->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))
            ->where('visit_type', $t)
            ->count(), $types);

        return [
            'datasets' => [
                [
                    'label' => 'Encounters',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981', '#ef4444', '#3b82f6', '#8b5cf6', '#f59e0b',
                    ],
                ],
            ],
            'labels' => $types,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

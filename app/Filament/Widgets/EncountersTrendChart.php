<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;

use App\Models\Encounter;
use Filament\Widgets\ChartWidget;

class EncountersTrendChart extends ChartWidget
{
    protected ?string $heading = 'Encounters — Last 14 days';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $hospitalId = auth()->user()?->hospital_id;
        $days = collect(range(13, 0))->map(fn ($i) => now()->subDays($i)->toDateString());

        $data = $days->map(fn ($date) => Encounter::query()
            ->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))
            ->whereDate('encounter_date', $date)
            ->count())->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Encounters',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.2)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $days->map(fn ($d) => \Carbon\Carbon::parse($d)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

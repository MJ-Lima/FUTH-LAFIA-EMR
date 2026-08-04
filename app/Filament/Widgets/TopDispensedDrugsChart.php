<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;

use App\Models\DispensingLog;
use Filament\Widgets\ChartWidget;

class TopDispensedDrugsChart extends ChartWidget
{
    protected  ?string $heading = 'Top 10 Dispensed Drugs (last 30 days)';

    protected  ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $hospitalId = auth()->user()?->hospital_id;
        $rows = DispensingLog::query()
            ->when($hospitalId, fn ($b) => $b->where('hospital_id', $hospitalId))
            ->where('dispensed_at', '>=', now()->subDays(30))
            ->selectRaw('drug_id, SUM(quantity) as qty')
            ->groupBy('drug_id')
            ->orderByDesc('qty')
            ->with('drug')
            ->limit(10)
            ->get();

        return [
            'datasets' => [[
                'label' => 'Units dispensed',
                'data' => $rows->pluck('qty')->toArray(),
                'backgroundColor' => '#f59e0b',
            ]],
            'labels' => $rows->map(fn ($r) => $r->drug?->name ?? '—')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

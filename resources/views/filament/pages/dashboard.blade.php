<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $dashboardTitle }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $dashboardSubtitle }}</p>
            </div>
            <div class="flex items-center gap-2">
                <x-filament::badge color="{{ $roleBadgeColor }}">{{ $role }}</x-filament::badge>
                <a href="/admin/reports-dashboard" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    <x-filament::icon icon="heroicon-o-arrow-down-tray" class="h-4 w-4" />
                    Export Report
                </a>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="flex items-center gap-3 flex-wrap bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <select class="rounded-lg border-gray-300 text-sm px-3 py-2">
                <option>All Clinics</option>
                @foreach(\App\Models\Clinic::all() as $clinic)
                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                @endforeach
            </select>
            <input type="date" class="rounded-lg border-gray-300 text-sm px-3 py-2" value="{{ now()->subWeek()->format('Y-m-d') }}" />
            <span class="text-gray-400">→</span>
            <input type="date" class="rounded-lg border-gray-300 text-sm px-3 py-2" value="{{ now()->format('Y-m-d') }}" />
            <button class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                <x-filament::icon icon="heroicon-o-funnel" class="h-4 w-4" />
                Apply Filters
            </button>
            <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                <x-filament::icon icon="heroicon-o-arrow-path" class="h-4 w-4" />
                Reset
            </button>
        </div>

        {{-- KPI Cards --}}
        @if (!empty($kpiCards))
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($kpiCards as $card)
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="rounded-lg p-2 bg-{{ $card['color'] }}-100">
                            <x-filament::icon icon="{{ $card['icon'] }}" class="h-5 w-5 text-{{ $card['color'] }}-600" />
                        </div>
                        @if ($card['change'] != 0)
                            <span class="text-xs font-semibold {{ $card['change'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $card['change'] > 0 ? '↑' : '↓' }} {{ abs($card['change']) }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $card['label'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $card['period'] }}</p>
                </div>
            @endforeach
        </div>
        @endif

        {{-- Quick Actions --}}
        @if (!empty($quickActions))
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($quickActions as $action)
                    <a href="{{ $action['url'] }}" class="inline-flex items-center gap-2 rounded-lg border border-{{ $action['color'] }}-300 px-3 py-2 text-sm font-medium text-{{ $action['color'] }}-700 hover:bg-{{ $action['color'] }}-50 transition">
                        <x-filament::icon icon="{{ $action['icon'] }}" class="h-4 w-4" />
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Charts Grid (3 columns) --}}
        @if (!empty($charts))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($charts as $chart)
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">{{ $chart['title'] }}</h3>
                        @if (isset($chart['period']))
                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">{{ $chart['period'] }}</span>
                        @endif
                    </div>

                    @if ($chart['type'] === 'donut')
                        {{-- Donut Chart --}}
                        <div class="flex items-center justify-center mb-4">
                            <div class="relative w-32 h-32">
                                {{-- CSS-based donut --}}
                                <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                                    @php
                                        $total = array_sum(array_column($chart['segments'], 'value'));
                                        $offset = 0;
                                    @endphp
                                    @foreach ($chart['segments'] as $seg)
                                        @php
                                            $pct = $total > 0 ? ($seg['value'] / $total) * 100 : 0;
                                            $dash = $pct * 100 / 100;
                                        @endphp
                                        <circle cx="18" cy="18" r="15.915"
                                            fill="none"
                                            stroke="{{ $seg['color'] }}"
                                            stroke-width="3"
                                            stroke-dasharray="{{ $pct }} {{100 - $pct}}"
                                            stroke-dashoffset="{{ $offset }}"
                                        />
                                        @php $offset -= $pct; @endphp
                                    @endforeach
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-xl font-bold text-gray-900">{{ $chart['center_value'] }}</span>
                                    <span class="text-xs text-gray-400">{{ $chart['center_label'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            @foreach ($chart['segments'] as $seg)
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $seg['color'] }}"></span>
                                        <span class="text-gray-600">{{ $seg['label'] }}</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ number_format($seg['value']) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($chart['type'] === 'line')
                        {{-- Line Chart (SVG-based) --}}
                        <div class="h-40">
                            @php
                                $maxVal = max(array_map(fn($d) => max($d['scheduled'], $d['completed']), $chart['data'])) ?: 1;
                            @endphp
                            <svg class="w-full h-full" viewBox="0 0 300 150" preserveAspectRatio="none">
                                {{-- Grid lines --}}
                                <line x1="0" y1="0" x2="300" y2="0" stroke="#f3f4f6" stroke-width="1" />
                                <line x1="0" y1="37" x2="300" y2="37" stroke="#f3f4f6" stroke-width="1" />
                                <line x1="0" y1="75" x2="300" y2="75" stroke="#f3f4f6" stroke-width="1" />
                                <line x1="0" y1="112" x2="300" y2="112" stroke="#f3f4f6" stroke-width="1" />
                                <line x1="0" y1="150" x2="300" y2="150" stroke="#f3f4f6" stroke-width="1" />

                                {{-- Scheduled line (purple) --}}
                                @php
                                    $points1 = '';
                                    $points2 = '';
                                    foreach ($chart['data'] as $i => $d) {
                                        $x = ($i / (count($chart['data']) - 1)) * 300;
                                        $y1 = 150 - ($d['scheduled'] / $maxVal) * 140;
                                        $y2 = 150 - ($d['completed'] / $maxVal) * 140;
                                        $points1 .= "$x,$y1 ";
                                        $points2 .= "$x,$y2 ";
                                    }
                                @endphp
                                <polyline points="{{ trim($points1) }}" fill="none" stroke="#8b5cf6" stroke-width="2" />
                                <polyline points="{{ trim($points2) }}" fill="none" stroke="#22c55e" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex gap-3 text-xs">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Scheduled</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span>Completed</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $chart['data'][0]['date'] }} - {{ $chart['data'][count($chart['data'])-1]['date'] }}</span>
                        </div>
                    @elseif ($chart['type'] === 'bar_horizontal')
                        {{-- Horizontal Bar Chart --}}
                        <div class="space-y-2">
                            @php $maxVal = max(array_column($chart['data'], 'value')) ?: 1; @endphp
                            @foreach ($chart['data'] as $bar)
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="text-gray-600">{{ $bar['label'] }}</span>
                                        <span class="font-semibold text-gray-900">{{ number_format($bar['value']) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ ($bar['value'] / $maxVal) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        {{-- Bottom Section: Table + Side Widgets --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Performance Table --}}
            @if (!empty($bottomTable))
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">{{ $bottomTable['title'] }}</h3>
                    <a href="/admin/clinics" class="text-xs text-emerald-600 hover:underline">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                @foreach ($bottomTable['columns'] as $col)
                                    <th class="py-2 pr-4">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bottomTable['rows'] as $row)
                                <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50">
                                    <td class="py-2 pr-4 font-medium text-gray-900">{{ $row['clinic'] }}</td>
                                    <td class="py-2 pr-4 text-gray-700">{{ $row['total_patients'] }}</td>
                                    <td class="py-2 pr-4 text-purple-600 font-semibold">{{ $row['new_patients'] }}</td>
                                    <td class="py-2 pr-4 text-gray-700">{{ $row['avg_wait'] }}</td>
                                    <td class="py-2 pr-4 text-green-600 font-semibold">{{ $row['completed'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Side Widgets --}}
            <div class="space-y-4">
                {{-- Stats widgets --}}
                @foreach ($sideWidgets as $widget)
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg p-2 bg-emerald-50">
                                <x-filament::icon icon="{{ $widget['icon'] }}" class="h-5 w-5 text-emerald-600" />
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">{{ $widget['title'] }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ $widget['value'] }}</p>
                                <p class="text-xs text-gray-400">{{ $widget['subtitle'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Recent Activities --}}
                @if (!empty($recentActivities))
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-700">Recent Activities</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach ($recentActivities as $activity)
                            <div class="flex items-start gap-3">
                                <div class="rounded-lg p-1.5 bg-gray-100">
                                    <x-filament::icon icon="{{ $activity['icon'] }}" class="h-4 w-4 text-gray-500" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['event'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $activity['detail'] }}</p>
                                </div>
                                <p class="text-xs text-gray-400 whitespace-nowrap">{{ $activity['time'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>

@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('content')
    @php
        $dashboardData = Cache::remember('dashboard_metrics', now()->addMinutes(1), function() {
            $data = [
                'totalIncidents' => \App\Models\Incident::count(),
                'totalVictims' => \App\Models\Victim::count(),
                'incidentsThisMonth' => \App\Models\Incident::whereMonth('created_at', now()->month)->count(),
                'resolvedCases' => \App\Models\Incident::whereHas('statusModel', function($q) {
                    $q->where('slug', 'resolved');
                })->count(),
                'incidentsByType' => \App\Models\Incident::selectRaw('type, count(*) as count')
                    ->groupBy('type')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->map(function($item) {
                        $item->formatted_type = ucwords(str_replace('_', ' ', $item->type));
                        return $item;
                    }),
                'incidentsByStatus' => \App\Models\Incident::with('statusModel')
                    ->selectRaw('status, count(*) as count')
                    ->groupBy('status')
                    ->get(),
                'incidentsByLocation' => \App\Models\Incident::selectRaw('location, count(*) as count')
                    ->whereNotNull('location')
                    ->groupBy('location')
                    ->orderBy('count', 'desc')
                    ->limit(10)
                    ->get(),
                'monthlyTrend' => \App\Models\Incident::selectRaw('
                        YEAR(occurred_at) as year,
                        MONTH(occurred_at) as month,
                        COUNT(*) as count')
                    ->where('occurred_at', '>', now()->subYear())
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get()
            ];

            // Format month names
            $data['monthlyTrend'] = $data['monthlyTrend']->map(function($item) {
                $date = DateTime::createFromFormat('!m', $item->month);
                $item->month_name = $date->format('M');
                $item->label = $item->month_name . ' ' . $item->year;
                return $item;
            });

            return $data;
        });

        extract($dashboardData);
    @endphp

    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @include('dashboard.backend.card', [
                'color' => 'red',
                'icon' => 'exclamation',
                'title' => 'Total Incidents',
                'value' => $totalIncidents
            ])

            @include('dashboard.backend.card', [
                'color' => 'blue',
                'icon' => 'users',
                'title' => 'Total Victims',
                'value' => $totalVictims
            ])

            @include('dashboard.backend.card', [
                'color' => 'yellow',
                'icon' => 'calendar',
                'title' => 'This Month',
                'value' => $incidentsThisMonth
            ])

            @include('dashboard.backend.card', [
                'color' => 'green',
                'icon' => 'check-circle',
                'title' => 'Resolved Cases',
                'value' => $resolvedCases
            ])
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Incidents by Type -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Incidents by Type</h3>
                    <div class="text-sm text-gray-500">{{ $incidentsByType->sum('count') }} total</div>
                </div>
                <div class="h-64">
                    <canvas id="incidentsByTypeChart"></canvas>
                </div>
            </div>

            <!-- Incidents by Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Incidents by Status</h3>
                    <div class="text-sm text-gray-500">{{ $incidentsByStatus->sum('count') }} total</div>
                </div>
                <div class="h-64">
                    <canvas id="incidentsByStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Trend -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Last 12 Months Trend</h3>
                <div class="h-64">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>

            <!-- Incidents by Location -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Top Locations</h3>
                    <div class="text-sm text-gray-500">{{ $incidentsByLocation->sum('count') }} total</div>
                </div>
                <div class="h-64">
                    <canvas id="incidentsByLocationChart"></canvas>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        // Common chart configuration
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                datalabels: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: ${context.raw} (${Math.round(context.parsed * 100 / context.dataset.data.reduce((a, b) => a + b, 0))}%)`;
                        }
                    }
                }
            }
        };

        // Incidents by Type Chart
        new Chart(
            document.getElementById('incidentsByTypeChart'),
            {
                type: 'doughnut',
                data: {
                    labels: @json($incidentsByType->pluck('formatted_type')),
                    datasets: [{
                        data: @json($incidentsByType->pluck('count')),
                        backgroundColor: [
                            '#EF4444', '#3B82F6', '#F59E0B', '#10B981',
                            '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'
                        ],
                    }]
                },
                options: chartConfig
            }
        );

        // Incidents by Status Chart
        new Chart(
            document.getElementById('incidentsByStatusChart'),
            {
                type: 'bar',
                data: {
                    labels: @json($incidentsByStatus->map(fn($item) => $item->statusModel?->name ?? ucfirst(str_replace('_', ' ', $item->status)))),
                    datasets: [{
                        label: 'Incidents',
                        data: @json($incidentsByStatus->pluck('count')),
                        backgroundColor: @json($incidentsByStatus->map(function ($item) {
                            if ($item->statusModel) {
                                switch ($item->statusModel->color_class) {
                                    case 'bg-yellow-100': return '#FEF9C3';
                                    case 'bg-blue-100': return '#DBEAFE';
                                    case 'bg-green-100': return '#D1FAE5';
                                    case 'bg-gray-100': return '#F3F4F6';
                                    default: return '#3B82F6'; // default blue
                                }
                            }
                            return '#3B82F6'; // default blue
                        })),
                        borderColor: @json($incidentsByStatus->map(function ($item) {
                            if ($item->statusModel) {
                                switch ($item->statusModel->text_color_class) {
                                    case 'text-yellow-800': return '#92400E';
                                    case 'text-blue-800': return '#1E40AF';
                                    case 'text-green-800': return '#065F46';
                                    case 'text-gray-800': return '#1F2937';
                                    default: return '#1E40AF'; // default blue
                                }
                            }
                            return '#1E40AF'; // default blue
                        })),
                        borderWidth: 1
                    }]
                },
                options: {
                    ...chartConfig,
                    scales: {
                        y: {beginAtZero: true}
                    }
                }
            }
        );

        new Chart(
            document.getElementById('monthlyTrendChart'),
            {
                type: 'line',
                data: {
                    labels: @json($monthlyTrend->pluck('label')),
                    datasets: [{
                        label: 'Incidents',
                        data: @json($monthlyTrend->pluck('count')),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {beginAtZero: true}
                    }
                }
            }
        );

        new Chart(
            document.getElementById('incidentsByLocationChart'),
            {
                type: 'polarArea',
                data: {
                    labels: @json($incidentsByLocation->pluck('location')),
                    datasets: [{
                        data: @json($incidentsByLocation->pluck('count')),
                        backgroundColor: [
                            '#EF4444', '#3B82F6', '#F59E0B', '#10B981',
                            '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'
                        ],
                    }]
                },
                options: chartConfig
            }
        );
    </script>
@endsection

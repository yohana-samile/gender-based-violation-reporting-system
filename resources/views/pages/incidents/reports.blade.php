@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Reports & Analytics') }}
    </h2>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-6">Incident Statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-md font-medium mb-4">Incidents by Status</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <canvas id="statusChart" height="200"></canvas>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-4">Incidents by Type</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <canvas id="typeChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($incidentsByStatus as $status => $incidents)
                            <div>
                                <h4 class="text-md font-medium mb-2 capitalize">{{ str_replace('_', ' ', $status) }} ({{ count($incidents) }})</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Victims
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($incidents as $incident)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('gbv.incident.show', $incident->uid) }}" class="text-blue-600 hover:text-blue-800">
                                                            {{ $incident->title }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 capitalize">
                                                    {{ str_replace('_', ' ', $incident->type) }}
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $incident->occurred_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $incident->victims->count() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        @foreach($incidentsByType as $type => $incidents)
                            <div>
                                <h4 class="text-md font-medium mb-2 capitalize">{{ str_replace('_', ' ', $type) }} ({{ count($incidents) }})</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Victims
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($incidents as $incident)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('gbv.incident.show', $incident->uid) }}" class="text-blue-600 hover:text-blue-800">
                                                            {{ $incident->title }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ implode(' ', getStatusClasses($incident->status)) }}">
                                                        {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $incident->occurred_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $incident->victims->count() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($incidentsByStatus->keys()->map(fn($k) => ucfirst(str_replace('_', ' ', $k)))->values()) !!},
                    data: {!! json_encode($incidentsByStatus->map(fn($i) => count($i))->values()) !!},
                    datasets: [{
                        backgroundColor: [
                            '#FBBF24', // yellow-400 for reported
                            '#60A5FA', // blue-400 for under_investigation
                            '#34D399', // green-400 for resolved
                            '#9CA3AF'  // gray-400 for closed
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            const typeCtx = document.getElementById('typeChart').getContext('2d');
            const typeChart = new Chart(typeCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($incidentsByType->keys()->map(fn($k) => ucfirst(str_replace('_', ' ', $k)))) !!},
                    datasets: [{
                        label: 'Number of Incidents',
                        data: {!! json_encode($incidentsByType->map(fn($i) => count($i))) !!},
                        backgroundColor: '#7C3AED', // purple-600
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection

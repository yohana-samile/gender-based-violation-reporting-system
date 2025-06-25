@extends('layouts.app')


@section('content')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
        <div class="flex space-x-4">
            <button onclick="exportToPDF()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF
            </button>
            <button onclick="exportToExcel()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </button>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Filter Section -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Filters</h3>
                        <form id="reportFilters" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" id="date_from" name="date_from" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" id="date_to" name="date_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->slug }}" {{ request('status') == $status->slug ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">All Types</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-4 flex justify-end space-x-3">
                                <button type="button" onclick="resetFilters()" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Reset
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <h3 class="text-lg font-medium mb-6">Incident Statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-md font-medium mb-4">Incidents by Status</h4>
                            <div class="bg-gray-50 p-4 rounded-lg" style="position: relative; height: 300px;">
                                <canvas id="statusChart" height="300"></canvas>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-4">Incidents by Type</h4>
                            <div class="bg-gray-50 p-4 rounded-lg" style="position: relative; height: 300px;">
                                <canvas id="typeChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach($incidentsByStatus as $status => $incidents)
                            <div class="incident-section bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-md font-medium capitalize">{{ str_replace('_', ' ', $status) }} ({{ count($incidents) }})</h4>
                                    <button onclick="exportSectionToExcel(this)" data-section="{{ str_replace(' ', '_', $status) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($incidents as $incident)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->id }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $incident->title }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $incident->type)) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->location }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->occurred_at->format('Y-m-d H:i') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        @foreach($incidentsByType as $type => $incidents)
                            <div class="incident-section bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-md font-medium capitalize">{{ str_replace('_', ' ', $type) }} ({{ count($incidents) }})</h4>
                                    <button onclick="exportSectionToExcel(this)" data-section="{{ str_replace(' ', '_', $type) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($incidents as $incident)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $incident->title }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $incident->type)) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->location }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $incident->occurred_at->format('Y-m-d H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</td>
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
@endsection

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        // Prepare chart data
        const statusData = {!! json_encode($incidentsByStatus->map(function($group) {
            return [
                'status' => $group->first()->status,
                'count' => $group->count(),
                'color' => $group->first()->statusModel->color_class ?? 'bg-blue-100'
            ];
        })) !!};

        const typeData = {!! json_encode($incidentsByType->map(function($group) {
            return [
                'type' => $group->first()->type,
                'count' => $group->count()
            ];
        })) !!};

        // Create status chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: Object.values(statusData).map(item =>
                    item.status.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                ),
                datasets: [{
                    label: 'Incidents by Status',
                    data: Object.values(statusData).map(item => item.count),
                    backgroundColor: Object.values(statusData).map(item => {
                        switch(item.color) {
                            case 'bg-yellow-100': return '#FEF9C3';
                            case 'bg-blue-100': return '#DBEAFE';
                            case 'bg-green-100': return '#D1FAE5';
                            case 'bg-gray-100': return '#F3F4F6';
                            default: return '#3B82F6';
                        }
                    }),
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Create type chart
        const typeCtx = document.getElementById('typeChart').getContext('2d');
        const typeChart = new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: Object.values(typeData).map(item =>
                    item.type.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                ),
                datasets: [{
                    label: 'Number of Incidents',
                    data: Object.values(typeData).map(item => item.count),
                    backgroundColor: '#7C3AED',
                    borderColor: '#6D28D9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Filter form submission
        document.getElementById('reportFilters').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams(formData).toString();
            window.location.href = window.location.pathname + '?' + params;
        });

        // Reset filters
        function resetFilters() {
            document.getElementById('reportFilters').reset();
            window.location.href = window.location.pathname;
        }

        // Export to PDF
        async function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');

            // Add title
            doc.setFontSize(18);
            doc.text('Incident Report', doc.internal.pageSize.getWidth() / 2, 30, { align: 'center' });

            // Add date range if filters are applied
            const dateFrom = document.getElementById('date_from').value;
            const dateTo = document.getElementById('date_to').value;
            if (dateFrom || dateTo) {
                doc.setFontSize(12);
                doc.text(`Date Range: ${dateFrom || 'Start'} to ${dateTo || 'End'}`, doc.internal.pageSize.getWidth() / 2, 50, { align: 'center' });
            }

            // Add charts
            const chartCanvas1 = document.getElementById('statusChart');
            const chartCanvas2 = document.getElementById('typeChart');

            const chartImage1 = await html2canvas(chartCanvas1);
            const chartImage2 = await html2canvas(chartCanvas2);

            doc.addImage(chartImage1, 'PNG', 40, 80, 240, 180);
            doc.addImage(chartImage2, 'PNG', 300, 80, 240, 180);

            // Add tables
            let yPosition = 300;

            document.querySelectorAll('.incident-section').forEach(async (section, index) => {
                if (index > 0 && yPosition > 600) {
                    doc.addPage();
                    yPosition = 40;
                }

                const title = section.querySelector('h4').textContent;
                doc.setFontSize(14);
                doc.text(title, 40, yPosition);
                yPosition += 20;

                const table = section.querySelector('table');
                const tableImage = await html2canvas(table);
                doc.addImage(tableImage, 'PNG', 40, yPosition, 500, tableImage.height * 500 / tableImage.width);
                yPosition += tableImage.height * 500 / tableImage.width + 20;
            });

            doc.save('Incident_Report_' + new Date().toISOString().slice(0, 10) + '.pdf');
        }

        // Export to Excel
        function exportToExcel() {
            const workbook = XLSX.utils.book_new();

            // Create summary sheet
            const summaryData = [
                ["Incident Report Summary"],
                ["Generated on", new Date().toLocaleString()],
                ["Date Range", `${document.getElementById('date_from').value || 'Start'} to ${document.getElementById('date_to').value || 'End'}`],
                ["Status Filter", document.getElementById('status').options[document.getElementById('status').selectedIndex].text],
                ["Type Filter", document.getElementById('type').options[document.getElementById('type').selectedIndex].text],
                [],
                ["Metric", "Count"],
                ["Total Incidents", {{ $incidentsByStatus->flatten()->count() }}],
                [],
                ["Incidents by Status:"],
                ...Object.entries({!! json_encode($incidentsByStatus->map(fn($i) => count($i))) !!})
                    .map(([status, count]) => [status.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' '), count]),
                [],
                ["Incidents by Type:"],
                ...Object.entries({!! json_encode($incidentsByType->map(fn($i) => count($i))) !!})
                    .map(([type, count]) => [type.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' '), count])
            ];

            XLSX.utils.book_append_sheet(
                workbook,
                XLSX.utils.aoa_to_sheet(summaryData),
                "Summary"
            );

            // Add data sheets for each status
            @foreach($incidentsByStatus as $status => $incidents)
            const wsData{{ $loop->index }} = [
                ["ID", "Title", "Type", "Location", "Reported Date", "Status"],
                    @foreach($incidents as $incident)
                [
                    "{{ $incident->id }}",
                    "{{ $incident->title }}",
                    "{{ ucfirst(str_replace('_', ' ', $incident->type)) }}",
                    "{{ $incident->location }}",
                    "{{ $incident->occurred_at->format('Y-m-d H:i') }}",
                    "{{ ucfirst(str_replace('_', ' ', $incident->status)) }}"
                ],
                @endforeach
            ];
            XLSX.utils.book_append_sheet(
                workbook,
                XLSX.utils.aoa_to_sheet(wsData{{ $loop->index }}),
                "{{ ucfirst(str_replace('_', ' ', $status)) }}".substring(0, 31)
            );
            @endforeach

            // Add data sheets for each type
            @foreach($incidentsByType as $type => $incidents)
            const wsTypeData{{ $loop->index }} = [
                ["ID", "Title", "Type", "Location", "Reported Date", "Status"],
                    @foreach($incidents as $incident)
                [
                    "{{ $incident->id }}",
                    "{{ $incident->title }}",
                    "{{ ucfirst(str_replace('_', ' ', $incident->type)) }}",
                    "{{ $incident->location }}",
                    "{{ $incident->occurred_at->format('Y-m-d H:i') }}",
                    "{{ ucfirst(str_replace('_', ' ', $incident->status)) }}"
                ],
                @endforeach
            ];
            XLSX.utils.book_append_sheet(
                workbook,
                XLSX.utils.aoa_to_sheet(wsTypeData{{ $loop->index }}),
                "{{ ucfirst(str_replace('_', ' ', $type)) }}".substring(0, 31)
            );
            @endforeach

            XLSX.writeFile(
                workbook,
                `Incident_Report_${new Date().toISOString().slice(0, 10)}.xlsx`
            );
        }

        // Export individual section to Excel
        function exportSectionToExcel(button) {
            const section = button.closest('.incident-section');
            const title = section.querySelector('h4').textContent.replace(/ \(\d+\)$/, '');
            const table = section.querySelector('table');

            const workbook = XLSX.utils.book_new();
            const ws = XLSX.utils.table_to_sheet(table);

            XLSX.utils.book_append_sheet(
                workbook,
                ws,
                title.substring(0, 31)
            );

            XLSX.writeFile(
                workbook,
                `${title.replace(/ /g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`
            );
        }

        // Initialize date pickers with any existing filter values
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById('date_from').value = urlParams.get('date_from') || '';
        document.getElementById('date_to').value = urlParams.get('date_to') || '';
        document.getElementById('status').value = urlParams.get('status') || '';
        document.getElementById('type').value = urlParams.get('type') || '';
    </script>
@endpush

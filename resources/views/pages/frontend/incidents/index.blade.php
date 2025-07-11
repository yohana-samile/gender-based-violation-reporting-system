@extends('layouts.frontend.app')
@section('title', 'Incident')

@section('content')
    <div class="py-6">
        <div class="flex justify-between mb-6">
            <h3 class="text-lg font-medium">All Reported Incidents</h3>
            <a href="{{ route('frontend.incident.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                Report New Incident
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden lg:rounded-lg">
            <div class="overflow-x-auto">
                <table id="incidentsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($incidents as $incident)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('frontend.incident.show', $incident->uid) }}"
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $incident->title }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($incident->description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ ucfirst(str_replace('_', ' ', $incident->type)) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $incident->status === 'reported' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $incident->status === 'under_investigation' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $incident->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $incident->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $incident->occurred_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('frontend.incident.show', $incident->uid) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('after-styles')
    <style>

    </style>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $('#incidentsTable').DataTable({
                dom: '<"flex justify-between items-center mb-4"<"flex-1"f><"flex"l>>rt<"flex justify-between items-center mt-4"<"flex-1"i><"flex"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search incidents...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                },
                initComplete: function () {
                    $('.dataTables_filter input').addClass(
                        'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm ' +
                        'focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                    );

                    $('.dataTables_length select').addClass(
                        'block w-full pl-3 pr-10 py-2 text-base border-gray-300 ' +
                        'focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md'
                    );
                }
            });
        });
    </script>
@endpush

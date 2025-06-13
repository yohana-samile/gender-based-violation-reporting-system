@extends('layouts.backend.mainlayout')
@section('title', 'Incident')

@section('content')
    <div class="py-6">
        <div class="flex justify-between mb-6">
            <h3 class="text-lg font-medium">All Reported Incidents</h3>
            <a href="{{ route('backend.incident.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                Report New Incident
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($incidents as $incident)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('incidents.show', $incident->id) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $incident->title }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($incident->description, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
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
                                <a href="{{ route('incidents.show', $incident->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                @can('update', $incident)
                                    <a href="{{ route('incidents.edit', $incident->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                @endcan
                                @can('delete', $incident)
                                    <form action="{{ route('incidents.destroy', $incident->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this incident?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No incidents found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4 bg-gray-50 sm:px-6">
                {{ $incidents->links() }}
            </div>
        </div>
    </div>
@endsection

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Causer type:</h2>
            <p class="text-sm text-gray-900">
                {{ class_basename($audits->user_type) ?? 'N/A' }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Date:</h2>
            <p class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($audits->created_at)->format('d M Y, H:i') }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Causer:</h2>
            <p class="text-sm text-gray-900">{{ $audits->user_email }}</p>
        </div>

        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Event</h2>
            <p class="text-sm text-gray-900">{{ ucfirst($audits->event) ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Subject type:</h2>
            <p class="text-sm text-gray-900">
                {{ class_basename($audits->auditable_type) ?? '-' }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-medium text-gray-500 mb-1">Subject ID:</h2>
            <p class="text-sm text-gray-900">{{ $audits->auditable_id ?? '-' }}</p>
        </div>
    </div>

    <!-- Changes table -->
    <div class="mb-3 mt-4">
        <h2 class="text-sm font-medium text-gray-500 mb-3 mt-4">Changes:</h2>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Previous value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New value</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($audits->new_values ?? [] as $key => $newValue)
                    <tr>
                        <td class="px-6 py-2">{{ $key }}</td>
                        <td class="px-6 py-2 text-red-500">
                            {{ $audits->old_values[$key] ?? '-' }}
                        </td>
                        <td class="px-6 py-2 text-blue-500">
                            {{ $newValue }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<legend class="text-sm font-semibold px-3 py-2 bg-gray-200 text-gray-700 rounded-md mb-4">
    {{ __('general info') }}
</legend>

<div class="space-y-4">
    <table class="w-full text-sm text-left border border-gray-200 rounded overflow-hidden shadow-sm">
        <tbody>
        <tr class="border-b">
            <td class="w-40 px-4 py-2 font-medium text-gray-700">
                @lang('Roles'):
            </td>
            <td class="px-4 py-2 text-gray-900">{{ $role->name }}</td>
        </tr>
        <tr class="border-b">
            <td class="w-40 px-4 py-2 font-medium text-gray-700">
                @lang('descriptions'):
            </td>
            <td class="px-4 py-2 text-gray-900">{{ $role->description }}</td>
        </tr>
        <tr class="border-b">
            <td class="w-40 px-4 py-2 font-medium text-gray-700">
                @lang('is_active'):
            </td>
            <td class="px-4 py-2">
                @if($role->isactive === 1)
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Yes</span>
                @else
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-black bg-yellow-400 rounded">No</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="w-40 px-4 py-2 font-medium text-gray-700">
                @lang('is_admin'):
            </td>
            <td class="px-4 py-2">
                @if($role->isadmin === 1)
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Yes</span>
                @else
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-black bg-yellow-500 rounded">No</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    {{ Html::labels('permission_id', __('Permission'), ['class' => 'text-sm font-medium text-gray-700']) }}
    <table class="w-full text-sm text-left border border-gray-200 bg-white rounded shadow mt-2">
        <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-4 py-2">{{ __('group') }}</th>
            <th class="px-4 py-2">{{ __('available permissions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $groupId => $groupPermissions)
            <tr class="border-t">
                <td class="px-4 py-2 text-gray-800">
                    {{ $groupPermissions->first()->permissionGroup->name ?? __('No Group Assigned') }}
                </td>
                <td class="px-4 py-2 text-gray-800">
                    @if($groupPermissions->isNotEmpty())
                        <p>{{ implode(', ', $groupPermissions->pluck('display_name')->toArray()) }}</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

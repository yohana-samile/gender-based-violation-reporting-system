<legend class="text-sm font-semibold px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-100 rounded-md mb-4">
    {{ __('general info') }}
</legend>

<div class="space-y-4">
    <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-600 rounded overflow-hidden shadow-sm dark:shadow dark:bg-gray-900">
        <tbody>
        <tr class="border-b dark:border-gray-700">
            <td class="w-40 px-4 py-2 font-medium text-gray-700 dark:text-gray-300">
                @lang('Roles'):
            </td>
            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $role->name }}</td>
        </tr>
        <tr class="border-b dark:border-gray-700">
            <td class="w-40 px-4 py-2 font-medium text-gray-700 dark:text-gray-300">
                @lang('descriptions'):
            </td>
            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $role->description }}</td>
        </tr>
        <tr class="border-b dark:border-gray-700">
            <td class="w-40 px-4 py-2 font-medium text-gray-700 dark:text-gray-300">
                @lang('is_active'):
            </td>
            <td class="px-4 py-2">
                @if($role->isactive === 1)
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Yes</span>
                @else
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-black dark:text-gray-900 bg-yellow-400 rounded">No</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="w-40 px-4 py-2 font-medium text-gray-700 dark:text-gray-300">
                @lang('is_admin'):
            </td>
            <td class="px-4 py-2">
                @if($role->isadmin === 1)
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Yes</span>
                @else
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-black dark:text-gray-900 bg-yellow-500 rounded">No</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    {{ Html::labels('permission_id', __('Permission'), ['class' => 'text-sm font-medium text-gray-700 dark:text-gray-300']) }}
    <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 rounded shadow mt-2">
        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
        <tr>
            <th class="px-4 py-2">{{ __('group') }}</th>
            <th class="px-4 py-2">{{ __('available permissions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $groupId => $groupPermissions)
            <tr class="border-t dark:border-gray-700">
                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                    {{ $groupPermissions->first()->permissionGroup->name ?? __('No Group Assigned') }}
                </td>
                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                    @if($groupPermissions->isNotEmpty())
                        <p>{{ implode(', ', $groupPermissions->pluck('display_name')->toArray()) }}</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

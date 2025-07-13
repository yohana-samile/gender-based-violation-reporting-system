<div class="flex flex-col md:flex-row gap-6">
    <div class="md:w-7/12">
        <legend class="text-sm font-semibold px-3 py-1 bg-gray-200 text-gray-600 rounded">{{ __('General info') }}</legend>

        <div class="mt-3">
            <table class="w-full border border-gray-200 rounded-md text-sm">
                <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700 w-1/3">Name:</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->name }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700">Email:</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->email }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700">Specializations:</td>
                    <td class="px-4 py-2 text-gray-900">
                        @if($user->specializations->isNotEmpty())
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($user->specializations as $specialist)
                                    <li>{{ $specialist->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-500">No specialization assigned</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="md:w-5/12">
        <legend class="text-sm font-semibold px-3 py-1 bg-gray-200 text-gray-600 rounded">{{ __('Sidebar Summary') }}</legend>

        <div class="mt-3">
            <table class="w-full border border-gray-200 rounded-md text-sm">
                <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700 w-1/3">Created at:</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->created_at }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700">Updated at:</td>
                    <td class="px-4 py-2 text-gray-900">{{ $user->updated_at }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700">Status:</td>
                    <td class="px-4 py-2">
                        @if($user->is_active)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ __('Active') }}</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium text-gray-700">Email verified at:</td>
                    <td class="px-4 py-2">
                        @if(is_null($user->email_verified_at))
                            <span class="text-red-600">{{ __('Email not verified') }}</span>
                        @else
                            {{ $user->email_verified_at }}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@extends('layouts.backend.mainlayout')
@section('title', 'User Roles')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Users with Role: {{ $role->name }}</h1>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 nextbyte-table">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            {{__('label.name')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__('label.email')}}
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            {{__('label.administrator.system.access_control.roles')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__('label.administrator.system.access_control.extra_permissions')}}
                        </th>
                        <th scope="col" class="px-6 py-3  bg-gray-50 dark:bg-gray-800">
                            {{__('label.action_crud.action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4">
                                {{ $user->permissions->pluck('name')->join(', ') ?: '-' }}
                            </td>
                            <td class="px-4 py-2 space-x-2 bg-gray-50 dark:bg-gray-800 text-sm">
                                <a href="{{ route('backend.show.user', $user->id) }}" class="text-blue-500 hover:underline text-xs">
                                    <i class="fa fa-eye text-xs"></i> {{ __('label.action_crud.preview') }}
                                </a>
                                <a href="{{ route('backend.edit.user', $user->id) }}" class="text-yellow-500 hover:underline text-xs">
                                    <i class="fa fa-edit text-xs"></i> {{ __('label.action_crud.edit') }}
                                </a>
                                <button class="text-red-500 dark:text-red-400 delete-user-btn" data-route="{{ route('backend.delete.user', $user->id) }}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <a href="{{ route('backend.user.activity', $user->id) }}" class="text-green-500 hover:underline text-xs"><i class="fa fa-history"></i> {{ __('label.action_crud.caused_activity') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-4">No users found for this role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush

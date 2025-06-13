@extends('layouts.backend.mainlayout')
@section('title', __('label.user_preview'))

@section('content')
    <div class="p-6 bg-white text-gray-900 dark:bg-gray-900 dark:text-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">
            {{ __('Users') }}
            <a href="{{ route('backend.user') }}" class="text-sm text-blue-600 dark:text-purple-400 hover:underline ml-2">
                <i class="fa fa-arrow-circle-left"></i>  Back to all Users
            </a>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 text-sm">
            <div>
                <strong class="text-gray-600 dark:text-gray-400">{{__('label.name')}}:</strong> {{ $user->name }}
            </div>
            <div>
                <strong class="text-gray-600 dark:text-gray-400">{{__('label.email')}}:</strong> {{ $user->email }}
            </div>
            <div class="col-span-2">
                <strong class="text-gray-600 dark:text-gray-400">User Roles & Permissions:</strong><br>
                <span class="ml-4">
                    <strong class="text-gray-600 dark:text-gray-400">Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}<br>
                    <strong class="text-gray-600 dark:text-gray-400">Permission:</strong> {{ $user->permissions->pluck('name')->join(' , ') }}
                </span>
            </div>
            <div>
                <strong class="text-gray-600 dark:text-gray-400">Created:</strong> {{ $user->created_at->format('d M Y, H:i') }}
            </div>
            <div>
                <strong class="text-gray-600 dark:text-gray-400">Updated:</strong> {{ $user->updated_at->format('d M Y, H:i') }}
            </div>
        </div>

        <div class="mt-6">
            <strong class="text-gray-600 dark:text-gray-400 block mb-2">Actions</strong>
            <div class="flex space-x-4 text-xs gap-4">
                <a href="{{ route('backend.edit.user', $user->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <button class="text-red-500 dark:text-red-400 delete-user-btn" data-route="{{ route('backend.delete.user', $user->id) }}">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
                <a href="{{ route('backend.user.activity', $user->id) }}" class="text-blue-600 dark:text-purple-400 hover:underline">
                    <i class="fa fa-history"></i> Activity
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush

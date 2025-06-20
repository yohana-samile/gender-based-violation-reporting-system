@extends('layouts.app')
@section('title', __('label.user_preview'))

@section('content')
    <div class="p-6 bg-white text-gray-900 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">
            {{ __('Users') }}
            <a href="{{ route('backend.user') }}"
               class="text-sm text-blue-600 hover:underline ml-2">
                <i class="fa fa-arrow-circle-left"></i> Back to all Users
            </a>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 text-sm">
            <div>
                <strong class="text-gray-600">{{__('Name')}}:</strong> {{ $user->name }}
            </div>
            <div>
                <strong class="text-gray-600">{{__('Email')}}:</strong> {{ $user->email }}
            </div>
            <div class="col-span-2">
                <strong class="text-gray-600">User Roles & Permissions:</strong><br>
                <span class="ml-4">
                    <strong class="text-gray-600">Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}<br>
                    <strong class="text-gray-600">Permission:</strong> {{ $user->permissions->pluck('name')->join(' , ') }}
                </span>
            </div>
            <div>
                <strong class="text-gray-600">Created:</strong> {{ $user->created_at->format('d M Y, H:i') }}
            </div>
            <div>
                <strong class="text-gray-600">Updated:</strong> {{ $user->updated_at->format('d M Y, H:i') }}
            </div>
        </div>

        <div class="mt-6">
            <strong class="text-gray-600 block mb-2">Actions</strong>
            <div class="flex space-x-4 text-xs gap-4">
                <a href="{{ route('backend.edit.user', $user->id) }}"
                   class="text-yellow-600 hover:underline">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <button class="text-red-500 delete-user-btn"
                        data-route="{{ route('backend.delete.user', $user->id) }}">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
                <a href="{{ route('backend.user.activity', $user->id) }}"
                   class="text-blue-600 hover:underline">
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

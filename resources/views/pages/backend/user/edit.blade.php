@extends('layouts.backend.app')
@section('title', 'User Edit')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white text-gray-900 rounded-md shadow-md">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Users
                <span class="text-base font-normal ml-2">
                <a href="{{ route('backend.user') }}" class="text-blue-600 hover:underline">
                    <i class="fa fa-arrow-circle-left"></i> Back to all Users
                </a>
            </span>
            </h1>
        </div>

        <form action="{{ route('backend.update.user', $user->id) }}" method="POST" class="async_accounts">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Password Confirmation</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                    <div class="flex items-center">
                        <span class="mr-3 text-sm font-medium text-gray-700">Inactive</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   class="sr-only peer" @checked(old('is_active', $user->is_active ?? true))>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">User Roles & Permissions</h2>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Roles</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($roles as $role)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                       {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}
                                       class="form-checkbox text-blue-600">
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Permissions</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($permissions as $permission)
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                       {{ $user->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}
                                       class="form-checkbox text-green-600">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <x-submit-button
                    icon="fas fa-save"
                    label="submit"
                    :showClose="true"
                    closeType="route"
                    closeTarget="{{ route('backend.user') }}"
                />
            </div>
        </form>
    </div>
@endsection

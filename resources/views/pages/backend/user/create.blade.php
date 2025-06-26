@extends('layouts.backend.app')
@section('title', 'Create Admin')

@section('content')
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <form class="mt-5 mx-auto" id="createAdminForm" method="POST" action="{{ route('backend.create.user') }}">
            @csrf
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Basic information') }}</h3>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700">
                        {{ __('Name') }}
                    </label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg p-2 mt-1 @error('name') border-red-500 @enderror">
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               placeholder="{{ __('name') }}" class="w-full bg-transparent focus:outline-none" required>
                    </div>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg p-2 mt-1 @error('email') border-red-500 @enderror">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="{{ __('Enter email') }}" class="w-full bg-transparent focus:outline-none"
                               required>
                    </div>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="is_super_admin" class="block text-sm font-medium text-gray-700 mb-2">Admin
                        Privileges</label>
                    <div class="flex items-center">
                        <span class="mr-3 text-sm font-medium text-gray-700">Regular User</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_super_admin" value="0">
                            <input type="checkbox" name="is_super_admin" id="is_super_admin" class="sr-only peer"
                                   @if(old('is_super_admin', isset($user) ? $user->is_super_admin : false)) checked @endif>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Super Admin</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Grant super administrator privileges</p>
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role_id" id="role"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Assign role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @if(old('role_id', isset($user) ? $user->role_id : '') == $role->id) selected @endif
                                    @if($role->name === 'administration') data-is-admin-role @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
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

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('password settings') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700">
                            {{ __('New Password') }}
                        </label>
                        <div
                            class="flex items-center border border-gray-300 rounded-lg p-2 mt-1 @error('password') border-red-500 @enderror">
                            <input id="new_password" type="password" name="password"
                                   placeholder="{{ __('new password') }}"
                                   class="w-full bg-transparent focus:outline-none" minlength="8" required>
                        </div>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation"
                               class="block text-sm font-semibold text-gray-700">
                            {{ __('confirm password') }}
                        </label>
                        <div class="flex items-center border border-gray-300 rounded-lg p-2 mt-1">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   placeholder="{{ __('confirm password') }}"
                                   class="w-full bg-transparent focus:outline-none" minlength="8"
                                   required>
                            <span
                                class="view_password bg-gray-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer"
                                onclick="togglePasswordVisibility('password_confirmation', this)">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <x-submit-button icon="fas fa-save" label="Save"/>
            </div>
        </form>
    </div>
@endsection

@push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#role').select2({
                placeholder: 'Assign role',
                allowClear: true,
                width: '100%'
            });

            const adminCheckbox = document.getElementById('is_super_admin');
            const roleSelect = $('#role');
            let adminRoleOption = $('option[data-is-admin-role]').val();

            function syncRoleWithAdminCheckbox() {
                if (adminCheckbox.checked && adminRoleOption) {
                    roleSelect.val(adminRoleOption).trigger('change');
                } else if (!adminCheckbox.checked && roleSelect.val() === adminRoleOption) {
                    roleSelect.val('').trigger('change');
                }
            }

            function syncAdminCheckboxWithRole() {
                if (adminRoleOption && roleSelect.val() === adminRoleOption) {
                    adminCheckbox.checked = true;
                } else {
                    adminCheckbox.checked = false;
                }
            }

            syncAdminCheckboxWithRole();

            adminCheckbox.addEventListener('change', function () {
                syncRoleWithAdminCheckbox();
            });

            roleSelect.on('change', function () {
                syncAdminCheckboxWithRole();
            });

            $(document).on('select2:open', function () {
                adminRoleOption = $('option[data-is-admin-role]').val();
            });
        });

        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                button.setAttribute('aria-label', 'Hide password');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                button.setAttribute('aria-label', 'Show password');
            }
        }

        // Also add toggle for the new password field if needed
        document.querySelector('.generate_password').addEventListener('click', function () {
            const passwordField = document.getElementById('new_password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
    </script>
@endpush

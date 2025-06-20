@extends('layouts.app')
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
                    <div class="flex items-center border border-gray-300 rounded-lg p-2 mt-1">
                        <input id="name" type="text" name="name" placeholder="{{ __('name') }}"
                               class="w-full bg-transparent focus:outline-none" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        {{ __('email') }}
                    </label>
                    <div class="flex items-center border border-gray-300 rounded-lg p-2 mt-1">
                        <input id="email" type="email" name="email" placeholder="{{ __('Enter email') }}"
                               class="w-full bg-transparent focus:outline-none" required>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('password settings') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700">
                            {{ __('new password') }}
                        </label>
                        <div class="flex items-center border border-gray-300 rounded-lg p-2 mt-1">
                            <input id="new_password" type="password" name="password"
                                   placeholder="{{ __('new password') }}"
                                   class="w-full bg-transparent focus:outline-none" minlength="8"
                                   required>
                            <span class="generate_password bg-red-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
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
                            <span class="view_password bg-gray-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer"
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
        document.querySelector('.generate_password').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
    </script>
@endpush

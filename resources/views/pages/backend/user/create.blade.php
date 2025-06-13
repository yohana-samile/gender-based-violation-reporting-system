@extends('layouts.backend.mainlayout')
@section('title', 'Create Admin')

@section('content')
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form class="mt-5 mx-auto" id="createAdminForm" method="POST" action="{{ route('backend.create.user') }}">
            @csrf
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Basic information') }}</h3>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ __('Name') }}
                    </label>
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                        <input id="name" type="text" name="name" placeholder="{{ __('name') }}"
                               class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ __('email') }}
                    </label>
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                        <input id="email" type="email" name="email" placeholder="{{ __('Enter email') }}"
                               class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('password settings') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('new password') }}
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="new_password" type="password" name="password" placeholder="{{ __('new password') }}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" minlength="8" required>
                            <span class="generate_password bg-red-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('confirm password') }}
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ __('confirm password') }}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" minlength="8" required>
                            <span class="view_password bg-gray-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <x-submit-button icon="fas fa-save" label="Save" />
            </div>
        </form>
    </div>
@endsection

@push('after-scripts')
    <script>
    </script>
@endpush


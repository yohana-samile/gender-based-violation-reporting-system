@extends('layouts.frontend.mainlayout')
@section('title', 'Emails')
@push('after-styles')
    <style>
        .data-row, #action-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .data-label {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            {{ __('label.email_managers') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount text-sm"></span>
        </h1>

        <div class="flex space-x-2">
            <x-switch-domain />

            <a href="javascript:void(0)" class="bg-indigo-500 text-white px-4 py-2 rounded flex items-center" onclick="openModal('addEmail')">
                <i class="fas fa-plus mr-2"></i> {{__('label.add_email') }}
            </a>
        </div>
    </div>

    <div class="table-container overflow-hidden sm:overflow-auto">
        <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table" id="whm-email-accounts">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4 items-center">
                        <input type="checkbox" class="mr-2"> {{__('label.email')}}
                    </th>
                    <th class="py-2 px-4">{{__('label.domain')}}</th>
                    <th class="py-2 px-4">{{__('label.usage_or_quota')}}</th>
                    <th class="py-2 px-4">{{__('label.action_crud.action')}}</th>
                </tr>
            </thead>
            <tbody class="text-dark dark:text-dark">
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="emailDetailsModal" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeEmailDetailModal()" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div id="email-details" class="mb-3 mt-4">
                    <!-- Email Details will be dynamically inserted here -->
                </div>

                <!-- Action Buttons in One Row -->
                <div class="mt-4 mb-3">
                    <div id="action-buttons">
                        <!-- Action buttons will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updateEmailDetails" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-4xl w-full relative">
            <button onclick="closeModal('updateEmailDetails')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div id="edit_email_modal"></div>
            </div>
        </div>
    </div>

    <div id="addEmail" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div onclick="event.stopPropagation()" class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeModal('addEmail')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <form id="addEmailEmailAccount" class="mt-5 max-w-sm mx-auto" method="POST" action="{{ route('frontend.store.email.account') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="domain" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> {{ __('label.select_domain') }}</label>
                        <select id="domain" name="domain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden disabled>{{ __('label.select_domain') }}</option>
                            @foreach($domains as $domain)
                                <option value="{{ $domain->name }}">{{ $domain->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('label.email') }}
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="email_username" type="text" name="email_username"
                                   placeholder="{{ __('label.enter_email') }}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                            <span id="email_domain" class="bg-gray-500 text-white px-3 py-2 rounded-r-lg min-w-[100px] text-center">
                                @domain.com
                            </span>
                        </div>
                        <input type="hidden" id="full_email" name="email">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{__('label.password')}}
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="password" type="password" name="password" placeholder="{{__('label.enter_password')}}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                            <span id="generate_password" class="bg-red-500 text-white px-3 py-2 rounded-r-lg min-w-[100px] text-center cursor-pointer">
                                {{__('label.generate')}}
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{__('label.confirm_password')}}
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="{{__('label.enter_password')}}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" required minlength="8">
                            <span class="bg-gray-500 text-white px-3 py-2 rounded-r-lg min-w-[100px] text-center view_password cursor-pointer">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>


                    <div class="mb-4">
                        <label for="quota" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{__('label.quota')}} ({{__('label.mb')}})</label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="quota" type="text" name="txtdiskquota" placeholder="{{__('label.enter_quota')}}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" value="{{ old('quota') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="send_welcome_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('label.send_welcome_email') }}
                        </label>
                        <div class="flex items-center mt-1">
                            {{-- This sends "0" if checkbox is not checked --}}
                            <input type="hidden" name="send_welcome_email" value="0">
                            <input id="send_welcome_email" type="checkbox" name="send_welcome_email" value="1"
                                   class="mr-2" {{ old('send_welcome_email') ? 'checked' : '' }}>
                            <span class="dark:text-gray-300">{{ __('label.yes_send') }}</span>
                        </div>
                    </div>

                    <x-submit-button icon="fas fa-save" label="label.action_crud.save_and_back" />
                </form>
            </div>

        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
            window.currentRoute = "{{ Route::currentRouteName() }}";
            let whmEmailAccounts = "{{ route('frontend.whm.accounts') }}";
            var deleteEmailRoute = "{{ route('frontend.delete.email.account', ':uid') }}";
            var editEmailRoute = "{{ route('frontend.email.update') }}";
    </script>
    <script src="{{ asset('asset/js/email-manager-script.js') }}"></script>
@endpush

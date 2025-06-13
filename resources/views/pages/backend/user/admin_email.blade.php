@extends('layouts.backend.mainlayout')
@section('title', 'Admin Emails')

@push('after-styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            <span class="bg-green-100 text-green-800 capitalize">{{ $adminName }}</span>
            {{ __('label.emails') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 text-sm entriesCount"></span>
        </h1>

        <div class="flex space-x-2">
            <x-switch-domain />

            <a href="javascript:void(0)" class="bg-green-500 text-white px-4 py-2 rounded flex items-center" onclick="openModal('addEmail')">
                <i class="fas fa-plus mr-2"></i> {{__('label.add_email') }}
            </a>

            <a href="javascript:void(0)" class="bg-indigo-500 text-white px-4 py-2 rounded flex items-center" onclick="openModal('assignDomain')">
                <i class="fas fa-plus mr-2"></i> {{__('label.assign_domain') }}
            </a>
        </div>
    </div>

    <div class="table-container overflow-hidden sm:overflow-auto">
        <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table text-center" id="admin_emails">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4 items-center"> {{__('label.email')}} </th>
                    <th class="py-2 px-4">{{__('label.action_crud.action')}}</th>
                </tr>
            </thead>
            <tbody class="text-dark dark:text-dark">
            </tbody>
        </table>
    </div>

    {{-- assign domain--}}
    <div id="assignDomain" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeModal('assignDomain')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="text-center">
                    <x-loader/>
                </div>
                <form class="mt-5 max-w-sm mx-auto async_accounts" method="POST" action="{{ route('backend.assign.domain') }}">
                    @csrf
                    <div class="mb-4">
                        <input id="admin_id" type="hidden" name="admin_id" value="{{ $adminUid }}">
                        <label for="domain" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> {{ __('label.select_domain') }}</label>
                        <select name="domain_id" class="nextbyte-select2 select_domain bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden disabled>{{ __('label.select_domain') }}</option>
                        </select>
                    </div>

                    <x-submit-button icon="fas fa-save" label="label.action_crud.save" />
                </form>
            </div>
        </div>
    </div>

    <div id="addEmail" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeModal('addEmail')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-yellow-500">{{__('label.add_email_to_this_admin')}}</h2>
                <div class="text-center">
                    <x-loader/>
                </div>
                <form class="mt-5 max-w-sm mx-auto async_accounts" method="POST" action="{{ route('backend.assign.email') }}">
                    @csrf
                    <div class="mb-4">
                        <input id="admin_id" type="hidden" name="admin_id" value="{{ $adminUid }}">
                        <label for="domain" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> {{ __('label.select_email') }}</label>
                        <select name="email_id" class="nextbyte-select2 select_email bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden disabled>{{ __('label.select_email') }}</option>
                        </select>
                    </div>

                    <x-submit-button icon="fas fa-save" label="label.action_crud.save" />
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        window.currentRoute = "{{ Route::currentRouteName() }}";
        const match = window.location.pathname.match(/\/get-admin-email\/([^\/]+)/);
        const adminUid = match ? match[1] : null;

        const domainUrl = "{{ route('backend.get.domain') }}";
        const adminDomainUrl = "{{ route('backend.fetch.admin.domain', ':adminUid') }}".replace(':adminUid', adminUid);

        const removeAdminEmailUrl = "{{ route('backend.remove.email', ['email' => ':emailId', 'adminUid' => ':adminUid']) }}";
        const emailUrl = "{{ route('backend.whm.accounts') }}";
        const adminEmailUrl = "{{ route('backend.fetch.admin.email', ':adminUid') }}".replace(':adminUid', adminUid);
    </script>

    <script src="{{ asset('asset/js/admin-domain-script.js') }}"></script>
    <script src="{{ asset('asset/js/admin-email-script.js') }}"></script>
@endpush

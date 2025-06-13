@extends('layouts.frontend.mainlayout')
@section('title', 'Domains')
@push('after-styles')
    <style>
        .data-row, .action-buttons {
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
            {{ __('label.domains') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount"></span>
        </h1>

        <div class="flex space-x-2">
            <x-switch-domain></x-switch-domain>
        </div>
    </div>


    <div class="table-container overflow-hidden sm:overflow-auto">
        <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table" id="whm-domain-accounts">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-900">
                <th class="py-2 px-4">#</th>
                <th class="py-2 px-4">{{__('label.domain')}}</th>
                <th class="py-2 px-4">{{__('label.package')}}</th>
                <th class="py-2 px-4">{{__('label.status')}}</th>
                <th class="py-2 px-4">{{__('label.action_crud.action')}}</th>
            </tr>
            </thead>
            <tbody class="text-dark dark:text-dark text-center">
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="domainInfo" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeDomainDetailModal()" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div id="domain-info" class="mb-3 mt-4">
            </div>

            <div class="mt-4 mb-3">
                <div class="action-buttons">
                    <!-- Action buttons will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        window.currentRoute = "{{ Route::currentRouteName() }}";
        let domains = "{{ route('frontend.domain.get') }}";
        let domain_full_data = "{{ route('frontend.domain.full.data', ':domain') }}";
    </script>
    <script src="{{ asset('asset/js/super-admin-domain-script.js') }}"></script>
@endpush

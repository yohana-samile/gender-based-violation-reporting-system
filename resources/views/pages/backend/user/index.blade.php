@extends('layouts.backend.mainlayout')
@section('title', 'Users')

@section('content')
    @php $usersScript = true; @endphp

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
    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            {{ __('Reporter') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount text-sm"></span>
        </h1>

        <div class="flex space-x-2">
            <a href="{{ route('backend.create.user') }}" class="bg-indigo-500 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-plus mr-2"></i> {{__('Reporter') }}
            </a>
        </div>
    </div>

    <div class="table-container overflow-hidden sm:overflow-auto">
        <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table" id="whm-customers">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4 items-center"> {{__('Name')}} </th>
                    <th class="py-2 px-4 items-center"> {{__('Email')}} </th>
                    <th class="py-2 px-4">{{__('is active?')}}</th>
                    <th class="py-2 px-4">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="text-dark dark:text-dark">
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="customerDetailsModal" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeModal('customerDetailsModal')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div id="customer-details" class="mb-3 mt-4">
                </div>

                <div class="mt-4 mb-3">
                    <div id="customer-action-buttons">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="updateCustomerDetails" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-4xl w-full relative">
            <button onclick="closeModal('updateCustomerDetails')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div id="edit_customer_modal"></div>
            </div>
        </div>
    </div>

    @if(isset($usersScript) && $usersScript)
        <script>
            window.currentRoute = "{{ Route::currentRouteName() }}";
            let whmCustomer = "{{ route('backend.get.user') }}";
            const deleteCustomerRoute = "{{ route('backend.delete.user', ':uid') }}";
            const editCustomerRoute = "{{ route('backend.update.user', ':uid') }}";
        </script>
        <script src="{{ asset('asset/js/users-script.js') }}"></script>
    @endif
@endsection

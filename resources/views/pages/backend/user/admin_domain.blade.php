@extends('layouts.backend.mainlayout')
@section('title', 'Admin-Domains')

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
            <span class="bg-green-100 text-green-800 capitalize">{{ $adminName }}</span>
            {{ __('label.domains') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 text-sm entriesCount"></span>
        </h1>

        <div class="flex space-x-2">
            <x-switch-domain></x-switch-domain>

            <div x-data="{ open: false }" class="relative inline-block text-left">
                <div class="inline-flex shadow-sm">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-l-md hover:bg-green-600 focus:outline-none"  onclick="openModal('changeToken')">
                        <i class="fas fa-recycle mr-2"></i> {{__('label.edit_token') }}
                    </button>

                    <!-- Dropdown Toggle -->
                    <button @click="open = !open"
                            class="inline-flex items-center px-2 bg-green-500 text-white text-sm font-medium rounded-r-md hover:bg-green-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     @click.away="open = false"
                     class="absolute right-0 z-10 "
                >

                    <form method="POST" action="{{ route('backend.cpanel.token.remove') }}" id="remove_token">
                        @csrf
                        <input id="admin_id" type="hidden" name="admin_id" value="{{ $adminUid }}">
                        <x-submit-button
                            icon="fas fa-trash"
                            label="label.remove_token"
                            buttonClass="bg-red-500 hover:bg-red-600"
                            :buttonId="'remove_token_btn'"
                            :labelId="'remove_token_label'"
                        />
                    </form>
                </div>
            </div>


            <a href="javascript:void(0)" class="bg-indigo-500 text-white px-4 py-2 rounded flex items-center" onclick="openModal('assignDomain')">
                <i class="fas fa-plus mr-2"></i> {{__('label.assign_domain') }}
            </a>
        </div>
    </div>

    <div class="table-container overflow-hidden sm:overflow-auto">
        <table class="mt-5 mb-3 w-full bg-white dark:bg-gray-800 rounded-lg nextbyte-table text-center" id="whm-admin-domains">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4 items-center"> {{__('label.domain')}} </th>
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
                        <select id="select2-example" name="domain_id" class="select_domain bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected hidden disabled>{{ __('label.select_domain') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600">
                        {{__('label.action_crud.save_and_back') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- change token--}}
    <div id="changeToken" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button onclick="closeModal('changeToken')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-yellow-500">{{__('label.cpanel_token_update')}}</h2>
                <div class="text-center">
                    <x-loader/>
                </div>
                <form action="{{ route('backend.cpanel.token.update') }}" method="POST" id="changeTokenApi">
                    @csrf
                    <div class="mb-4">
                        <input id="admin_id" type="hidden" name="admin_id" value="{{ $adminUid }}">
                        <label for="cpanel_username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{__('label.cpanel_user')}}</label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="cpanel_username" type="text" name="old_name" placeholder="{{__('label.cpanel_user')}}"
                                   class="w-full bg-transparent focus:outline-none dark:text-gray-200" value="{{ $token->cpanel_username ?? '' }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="new_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{__('label.cpanel_new_name')}}</label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="new_name" type="text" name="new_name" placeholder="{{__('label.cpanel_new_name')}}" class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="whm_api_token" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('label.cpanel_token') }}
                        </label>

                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="whm_api_token" type="text" readonly class="w-full bg-transparent focus:outline-none dark:text-gray-200" value="{{ $token->whm_api_token ?? '' }}">
                            <button type="button" onclick="copyToClipboard()" class="ml-2 text-gray-500 hover:text-gray-800 dark:hover:text-white" title="Copy">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <x-submit-button icon="fas fa-save" label="label.action_crud.save" />
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        document.addEventListener("click", function (event) {
            $('#changeTokenApi').on('submit', function (e) {
                e.preventDefault();

                {{--pleaseWaitSubmitButton("submit_btn", "submit_label", "{{ trans('label.please_wait') }}", 1);--}}
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            $('#submit_btn').prop('disabled', false).text("{{ __('label.buttons.general.resubmit') }}");
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.message || 'An error occurred.';
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: errorMessage,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $('#submit_btn').prop('disabled', false).text("{{ __('label.buttons.general.resubmit') }}");
                    }
                });
            });


            // function pleaseWaitSubmitButton(submit_button_id,label_wait_id, please_wait_text, action_type)
            // {
            //     if(action_type === 1){
            //         $('#'+ submit_button_id).prop('hidden', true);
            //         $('#' + label_wait_id).text(please_wait_text).change();
            //     }else{
            //         $('#'+ submit_button_id).prop('hidden', false);
            //         $('#' + label_wait_id).text('').change();
            //
            //     }
            // }


            // remove token
            const submitBtn = event.target.closest("form#remove_token button[type='submit']");
            if (!submitBtn) return;

            event.preventDefault();
            {{--pleaseWaitSubmitButton("remove_token_btn", "remove_token_label", "{{ trans('label.please_wait') }}", 1);--}}
            const form = submitBtn.closest("form");
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const adminId = form.querySelector('input[name="admin_id"]').value;
                    $.ajax({
                        url: form.getAttribute("action"),
                        type: 'POST',
                        data: JSON.stringify({ admin_id: adminId }),
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    icon: 'success',
                                    title: response.message
                                }).then(() => {
                                    window.location.reload();
                                });

                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    icon: 'error',
                                    title: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            let errorMessage = 'An error occurred while processing your request.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                icon: 'error',
                                title: errorMessage,
                            });
                        }
                    });
                }
            });
        });


        window.currentRoute = "{{ Route::currentRouteName() }}";
        const match = window.location.pathname.match(/\/get-admin-domain\/([^\/]+)/);
        const adminUid = match ? match[1] : null;
        const domainUrl = "{{ route('backend.get.domain') }}";
        const adminDomainUrl = "{{ route('backend.fetch.admin.domain', ':adminUid') }}".replace(':adminUid', adminUid);
        const removeAdminDomainUrl = "{{ route('backend.remove.domain', ['domain' => ':domainId', 'adminUid' => ':adminUid']) }}";
    </script>
    <script src="{{ asset('asset/js/admin-domain-script.js') }}"></script>
@endpush

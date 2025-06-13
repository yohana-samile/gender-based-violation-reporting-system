@extends('layouts.backend.mainlayout')
@section('title', __('roles_permissions'))

@section('content')

    <form method="POST" action="{{ route('backend.role.store') }}" id="storeRoleAndPermission">
        @csrf
        <input type="hidden" name="action_type" id="action_type" value="1" required>
        <input type="hidden" name="today" id="today" value="{{ getTodayDate() }}" required>

         <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    {{ Html::labels('name', __('name'), ['class' =>'required_asterik block text-sm font-medium text-gray-700 dark:text-gray-300']) }}
                    {{ Html::texts('name', null, ['class'=>'mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'id' => 'name', 'autocomplete' => 'off']) }}
                    {!! $errors->first('name', '<span class="text-red-500 text-sm">:message</span>') !!}
                </div>

                <div>
                    {{ Html::labels('description', __('descriptions'), ['class' =>'required_asterik block text-sm font-medium text-gray-700 dark:text-gray-300']) }}
                    {{ Html::texts('description', null, ['class'=>'mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm', 'id' => 'description', 'autocomplete' => 'off']) }}
                    {!! $errors->first('description', '<span class="text-red-500 text-sm">:message</span>') !!}
                </div>
            </div>

            <div class="mt-6">
                {{ Html::labels('permission_id', __('Permission'), ['class' =>'block text-sm font-medium text-gray-700 dark:text-gray-300']) }}
                <table class="min-w-full text-sm mt-3 border dark:border-gray-700 bg-white dark:bg-gray-800 shadow rounded-lg permissionTable">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-left">{{ __('label.group') }}</th>
                        <th class="px-4 py-2 text-left">
                            <label class="inline-flex items-center">
                                <input class="grand_selectall mr-2" type="checkbox">
                                {{ __('Select All') }}
                            </label>
                        </th>
                        <th class="px-4 py-2 text-left">{{ __("Available permissions") }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($permissions as $groupId => $groupPermissions)
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="p-4 text-gray-800 dark:text-gray-200">
                                {{ $groupPermissions->first()->permissionGroup->name ?? 'No Group Assigned' }}
                            </td>
                            <td class="p-4 text-gray-800 dark:text-gray-200">
                                <label class="inline-flex items-center">
                                    <input class="selectall mr-2" type="checkbox">
                                    {{ __('Select All') }}
                                </label>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-3">
                                    @forelse($groupPermissions as $permission)
                                        <label class="inline-flex items-center text-gray-700 dark:text-gray-200">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="permissioncheckbox mr-2">
                                            {{ $permission->display_name }}
                                        </label>
                                    @empty
                                        <p class="text-gray-500">{{ __('no permission group') }}</p>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="flex items-center space-x-2">
                    {{ Html::checkbox('isactive', 1, null, ['class' => 'form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500', 'id' => 'isactive']) }}
                    {{ Html::labels('isactive', __('is_active'), ['class' => 'text-sm font-medium text-gray-700 dark:text-gray-300']) }}
                </div>

                <div class="flex items-center space-x-2">
                    {{ Html::checkbox('isadmin', 1, null, ['class' => 'form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500', 'id' => 'isadmin']) }}
                    {{ Html::labels('isadmin', __('is_admin'), ['class' => 'text-sm font-medium text-gray-700 dark:text-gray-300']) }}
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <x-submit-button
                    icon="fas fa-save"
                    label="Submit"
                    :showClose="true"
                    closeType="route"
                    closeTarget="{{ route('backend.role.index') }}"
                />
            </div>
        </div>
    </div>
    </form>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $('#storeRoleAndPermission').on('submit', function (e) {
                e.preventDefault();

                pleaseWaitSubmitButton("submit_btn", "submit_label", "{{ trans('please wait') }}", 1);

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
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        $('#submit_btn').prop('disabled', false).text("{{ __('Submit') }}");
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
                        $('#submit_btn').prop('disabled', false).text("{{ __('Submit') }}");
                    }
                });
            });

            function initializeCheckBoxes() {
                updateSelectAll();
                updateGrandSelectAll();
            }

            function updateSelectAll() {
                $('.selectall').each(function () {
                    let checkboxes = $(this).closest('tr').find('.permissioncheckbox');
                    let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                    $(this).prop('checked', allChecked);
                });
            }

            function updateGrandSelectAll() {
                let allChecked = $('.selectall').length === $('.selectall:checked').length;
                $('.grand_selectall').prop('checked', allChecked);
            }

            $('.permissionTable').on('click', '.selectall', function () {
                let isChecked = $(this).is(':checked');
                $(this).closest('tr').find('.permissioncheckbox').prop('checked', isChecked);
                updateGrandSelectAll();
            });

            $('.permissionTable').on('click', '.grand_selectall', function () {
                let isChecked = $(this).is(':checked');
                $('.selectall, .permissioncheckbox').prop('checked', isChecked);
            });

            $('.permissionTable').on('click', '.permissioncheckbox', function () {
                let row = $(this).closest('tr');
                let checkboxes = row.find('.permissioncheckbox');
                let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                row.find('.selectall').prop('checked', allChecked);
                updateGrandSelectAll();
            });

            initializeCheckBoxes();
        });
    </script>
@endpush

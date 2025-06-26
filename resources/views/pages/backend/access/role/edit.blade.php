@extends('layouts.backend.app')
@section('title', __('label.administrator.system.access_control.roles_permissions'))

@section('content')
    <form method="POST" action="{{ route('backend.role.update', $role->uid) }}" id="editRoleAndPermission">
        @csrf
        @method("PUT")
        <input type="hidden" name="resource_id" id="resource_id" value="{{ $role->id }}" required>
        <input type="hidden" name="action_type" id="action_type" value="2" required>
        <input type="hidden" name="today" id="today" value="{{ getTodayDate() }}" required>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        {{ __('name') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{ $role->name }}" required placeholder=""
                           autocomplete="off"
                           class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        {{ __('descriptions') }}
                    </label>
                    <input type="text" name="description" id="description" value="{{ $role->description }}"
                           placeholder="" autocomplete="off"
                           class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                {{ Html::labels('permission_id', __('Permission'), ['class' => 'font-semibold text-gray-800']) }}
                <div class="overflow-x-auto mt-4 border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 bg-white text-sm permissionTable">
                        <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('label.group') }}</th>
                            <th class="px-4 py-3 text-left">
                                <label class="flex items-center space-x-2">
                                    <input class="grand_selectall rounded" type="checkbox">
                                    <span>{{ __('select all') }}</span>
                                </label>
                            </th>
                            <th class="px-4 py-3 text-left">{{ __('Available permissions') }}</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($permissions as $groupId => $groupPermissions)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ $groupPermissions->first()->permissionGroup->name ?? __('no group assigned') }}
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center space-x-2">
                                        <input class="selectall rounded" type="checkbox">
                                        <span>{{ __('Select all') }}</span>
                                    </label>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-3">
                                        @forelse($groupPermissions as $permission)
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" name="permissions[]"
                                                       value="{{ $permission->id }}" class="permissioncheckbox rounded"
                                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <span>{{ $permission->display_name }}</span>
                                            </label>
                                        @empty
                                            <p class="text-sm text-gray-500">{{ __('no permission group') }}</p>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="isactive"
                               class="form-checkbox rounded text-blue-600"
                               id="isactive" value="1" @if($role->isactive) checked @endif>
                        <span class="text-gray-700">{{ __('is_active') }}</span>
                    </label>
                </div>

                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="isadmin"
                               class="form-checkbox rounded text-blue-600"
                               id="isadmin" value="1" @if($role->isadmin) checked @endif>
                        <span class="text-gray-700">{{ __('is_admin') }}</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <x-submit-button
                        icon="fas fa-check"
                        label="Submit"
                        :showClose="true"
                        closeType="route"
                        closeTarget="{{ route('backend.role.profile', ['role' => $role->uid]) }}"
                />
            </div>
        </div>
    </form>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            $('#editRoleAndPermission').on('submit', function (e) {
                e.preventDefault();

                pleaseWaitSubmitButton("submit_btn", "submit_label", "{{ trans('label.please_wait') }}", 1);

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

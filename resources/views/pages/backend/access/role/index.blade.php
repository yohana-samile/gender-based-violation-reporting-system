@extends('layouts.backend.app')
@section('title', 'Roles')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            {{ __('Roles') }}
            <span class="mt-2 text-gray-600 entriesCount text-sm"></span>
        </h1>

        <div class="flex space-x-2">
            @if(access()->allow('manage_role_and_permissions'))
                <div class="flex justify-end mb-4">
                    <a href="{{ route('backend.role.create') }}"
                       class="px-4 py-2 mb-3 inline-flex items-center text-white bg-indigo-500 hover:bg-indigo-500 rounded">
                        <i class="fas fa-plus-circle mr-1"></i> {{ __('Add role') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="table-container relative overflow-x-auto shadow-md sm:overflow-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 nextbyte-table"
                   id="role-table">
                <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50">
                        {{ __('roles') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Descriptions') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Users') }}
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50">
                        {{ __('is_active') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('is_admin') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            let tableElement = document.getElementById("role-table");

            if (!tableElement) {
                console.warn("DataTable is already initialized or element not found.");
                return;
            }

            new DataTable(tableElement, {
                processing: false,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                pageLength: 10,
                language: {
                    info: "",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    lengthMenu: "Show _MENU_ entries"
                },
                ajax: '{{ route('backend.role.get_all_for_dt') }}',

                columns: [
                    {data: 'display_name', name: 'roles.display_name', orderable: true, searchable: true},
                    {data: 'description', name: 'roles.description', orderable: true, searchable: true},
                    {
                        data: 'users_count',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let count = data || 0;
                            return `<span class="font-medium text-white bg-blue-500 px-2 py-1 rounded-lg">
                                <a href="{{ route('backend.role.users', '__UID__') }}"
                                   onclick="event.stopPropagation();"
                                   > ${count} user${count !== 1 ? 's' : ''} <i class="fa fa-eye"></i> </a>
                                </span>`.replace('__UID__', row.uid);
                        }
                    },
                    {
                        data: "isactive", name: 'roles.isactive', orderable: false, searchable: true,
                        render: function (data, type, row) {
                            return data === 1
                                ? `<div class="bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Active</div>`
                                : `<div class="bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Inactive</div>`;
                        }
                    },
                    {
                        data: "isadmin", name: 'roles.isadmin', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            return data === 1
                                ? `<div class="bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Yes</div>`
                                : `<div class="bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">No</div>`;
                        }
                    },
                    {
                        data: "uid", name: 'roles.uid', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            const previewRoute = `{{ route('backend.role.profile', ['role' => '__ROLE_UID__']) }}`.replace('__ROLE_UID__', row.uid);
                            const deleteRoute = `{{ route('backend.role.delete', ['role' => '__ROLE_UID__']) }}`.replace('__ROLE_UID__', row.uid);

                            return `
                                <a href="${previewRoute}" onclick="event.stopPropagation();" class="text-blue-500 hover:underline mr-2 text-xs">
                                    <i class="fa fa-eye"></i> Preview
                                </a>
                                <button onclick="deleteRole('${deleteRoute}'); event.stopPropagation();" class="text-red-500 hover:underline text-xs">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            `;
                        }
                    }
                ],

                pagingType: "full_numbers",
                drawCallback: function (settings) {
                    let info = settings.oInstance.api().page.info();
                    let entriesCount = document.querySelector(".entriesCount");
                    if (entriesCount) {
                        entriesCount.textContent = `Showing ${info.start + 1} to ${info.end} of ${info.recordsDisplay} entries`;
                    }
                }
            });
        });

        function deleteRole(route) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the role.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(route, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                icon: data.status === 200 ? "success" : "error",
                                title: data.message,
                            }).then(() => {
                                if (data.status === 200) {
                                    $('#role-table').DataTable().ajax.reload(null, false);
                                }
                            });
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        });
                }
            });
        }
    </script>
@endpush

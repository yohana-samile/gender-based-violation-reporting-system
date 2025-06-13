@extends('layouts.backend.mainlayout')
@section('title', 'Permissions')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            {{ __('Permission') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount text-sm"></span>
        </h1>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="table-container relative overflow-x-auto shadow-md sm:overflow-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 nextbyte-table" id="permission-table">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            {{ __('Roles') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Descriptions') }}
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            {{ __('is_active') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('is_admin') }}
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
            let tableElement = document.getElementById("permission-table");

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
                ajax: '{{ route('backend.permission.get_all_for_dt') }}',

                columns: [
                    { data: 'display_name', name: 'permissions.display_name', orderable: true, searchable: true },
                    { data: 'description', name: 'permissions.description', orderable: true, searchable: true },
                    {
                        data: "isactive", name: 'permissions.isactive', orderable: false, searchable: true,
                        render: function (data, type, row) {
                            return data === 1
                                ? `<div class="bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Active</div>`
                                : `<div class="bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Inactive</div>`;
                        }
                    },
                    {
                        data: "isadmin", name: 'permissions.isadmin', orderable: false, searchable: false,
                        render: function (data, type, row) {
                            return data === 1
                                ? `<div class="bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">Yes</div>`
                                : `<div class="bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">No</div>`;
                        }
                    },
                ],

                pagingType: "full_numbers",
                drawCallback: function (settings) {
                    applyDarkModeToDataTable();
                    let info = settings.oInstance.api().page.info();
                    let entriesCount = document.querySelector(".entriesCount");
                    if (entriesCount) {
                        entriesCount.textContent = `Showing ${info.start + 1} to ${info.end} of ${info.recordsDisplay} entries`;
                    }
                }
            });
        });

    </script>
@endpush

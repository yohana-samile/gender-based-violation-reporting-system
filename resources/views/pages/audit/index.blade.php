@extends('layouts.mainlayout')
@section('title', 'System Logs')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <h1 class="text-xl font-bold">
            {{ __('Audits') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount text-sm"></span>
        </h1>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 nextbyte-table"
               id="audit-table">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    {{__('Event')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{__('User email')}}
                </th>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    {{__('Created_at')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{__('Ip_address')}}
                </th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            let tableElement = document.getElementById("audit-table");

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
                ajax: '{{ route('backend.audit.get_all_for_dt') }}',

                columns: [
                    {data: 'event', name: 'audits.event', orderable: true, searchable: true},
                    {data: 'user_email', name: 'user_email', orderable: true, searchable: true},
                    {
                        data: 'created_at',
                        name: 'audits.created_at',
                        render: function (data, type, row) {
                            const date = new Date(data);
                            return date.toLocaleString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    },
                    {data: 'ip_address', name: 'audits.ip_address', orderable: false, searchable: true},
                ],

                fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    const url = `{{ route('backend.audit.profile', ['audit' => '__AUDIT_UID__']) }}`.replace('__AUDIT_UID__', aData.id);

                    $(nRow).click(function () {
                        document.location.href = url;
                    }).hover(function () {
                        $(this).css('cursor', 'pointer');
                    }, function () {
                        $(this).css('cursor', 'auto');
                    });
                },

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

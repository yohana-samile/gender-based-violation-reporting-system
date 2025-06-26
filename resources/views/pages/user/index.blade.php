@extends('layouts.app')
@section('title', 'Users')

@section('content')
    <style>
        .table-container {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        tr.clickable-row {
            cursor: pointer;
        }
        tr.clickable-row:hover {
            background-color: #f3f4f6;
        }
    </style>

    <div class="flex items-center justify-between mb-4 mt-5">
        <h1 class="text-xl font-bold">
            {{ __('Users') }}
            <span class="mt-2 text-gray-600 entriesCount text-sm"></span>
        </h1>

        <div class="flex space-x-2">
            <a href="{{ route('backend.create.user') }}"
               class="bg-indigo-500 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-plus mr-2"></i> {{__('Add User') }}
            </a>
        </div>
    </div>

    <div class="table-container overflow-hidden sm:overflow-auto">
        <table id="usersTable" class="mt-5 mb-3 w-full bg-white rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 items-center">#</th>
                    <th class="py-2 px-4 items-center"> {{__('Name')}} </th>
                    <th class="py-2 px-4 items-center"> {{__('Email')}} </th>
                    <th class="py-2 px-4">{{__('Status')}}</th>
                    <th class="py-2 px-4">{{__('Admin')}}</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var url = "{{ url('/') }}";
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route('backend.get.user') }}',
                        type: 'get'
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        { data: 'name', name: 'name', orderable: false, searchable: true },
                        { data: 'email', name: 'email', orderable: false, searchable: true },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function(data, type, row) {
                                return data ?
                                    '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>' :
                                    '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>';
                            }
                        },
                        {
                            data: 'is_super_admin',
                            name: 'is_super_admin',
                            render: function(data, type, row) {
                                return data ?
                                    '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Admin</span>' :
                                    '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">User</span>';
                            }
                        },
                    ],
                    rowCallback: function(nRow, aData) {
                        $(nRow).addClass('clickable-row').click(function() {
                            document.location.href = aData['show_url'];
                        });
                    }
                });
            });
        });
    </script>
@endsection

@extends('layouts.backend.mainlayout')
@section('title', __('label.administrator.system.audits.logs'))

@push('styles')
    <style>
        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Log Manager</h1>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">File Name</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">Last Modified</th>
                        <th scope="col" class="px-6 py-3">File Size</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logFiles as $index => $logFile)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">{{ $logFile['name'] }}</td>
                            <td class="px-6 py-4">{{ $logFile['date'] }}</td>
                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">{{ $logFile['last_modified'] }}</td>
                            <td class="px-6 py-4">{{ $logFile['size'] }}</td>
                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800 mr-2 text-xs">
                                <div class="flex space-x-2">
                                    <a href="{{ route('backend.logs.show', $logFile['name']) }}" class="text-blue-600 hover:text-blue-900"><i class="fa fa-eye"></i> {{__('label.action_crud.preview')}}</a>
                                    <a href="{{ route('backend.logs.download', $logFile['name']) }}" class="text-green-600 hover:text-green-900"><i class="fa fa-download"></i> {{__('label.action_crud.download')}}</a>
                                    <button class="text-red-500 dark:text-red-400 delete-log-btn" data-route="{{ route('backend.logs.delete', $logFile['name']) }}">
                                        <i class="fa fa-trash-alt"></i> {{__('label.action_crud.delete')}}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No log files found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logFiles->count() > 0)
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Showing') }} {{ $logFiles->count() }} {{ __('log files') }}
            </div>
        @endif
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-log-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const deleteRoute = this.dataset.route;
                    deleteLog(deleteRoute);
                });
            });
        });

            function deleteLog (route) {
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
                    fetch(route, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                icon: data.status === 200 ? "success" : "error",
                                title: data.message,
                            }).then(() => {
                                console.log(data.url_destination);
                                console.log(data.status);
                                if (data.status === 200) {
                                    window.location.reload();
                                }
                            });
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Failed to connect to the server.", "error");
                        });
                }
            });
        };
    </script>
@endpush

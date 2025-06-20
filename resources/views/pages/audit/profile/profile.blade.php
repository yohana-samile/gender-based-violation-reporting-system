@extends('layouts.app')
@section('title',  __('label.administrator.system.audits.audit_logs'))

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="bg-white text-gray-800 p-6 rounded-md shadow-md">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">
                Activity Logs
                <span class="text-sm">
                    <a href="{{ route('backend.audit.index') }}" class="text-blue-500 hover:underline"><i
                            class="fa fa-arrow-circle-left"></i> Back to all activity logs</a>
                </span>
            </h2>
        </div>

        @include('pages.audit.profile.includes.general_info')
    </div>
@endsection

@push('after-scripts')
    <script>

    </script>
@endpush

@extends('layouts.frontend.mainlayout')
@section('title', __('label.administrator.system.audits.my_logs'))

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="bg-gray-900 text-gray-100 p-6 rounded-md shadow-md">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">
                Activity Logs
                <span  class="text-sm">
                <a href="{{ route('frontend.my_logs.index') }}" class="text-blue-500 hover:underline"><i class="fa fa-arrow-circle-left"></i> Back to all activity logs</a>
            </span>
            </h2>
        </div>
        @include('pages.frontend.my_logs.profile.includes.general_info')
    </div>
@endsection

@push('after-scripts')
    <script>
    </script>
@endpush

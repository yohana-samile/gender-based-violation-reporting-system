@extends('layouts.mainlayout')
@section('title', 'User Activity')

@push('after-styles')
    <style>
    </style>
@endpush

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <h1 class="text-xl font-bold">
            {{ __('label.administrator.system.audits.caused_activity') }}
            <span class="mt-2 text-gray-600 dark:text-gray-400 entriesCount text-sm">
                ({{ $user->email ?? 'Unknown User' }})
            </span>
        </h1>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 nextbyte-table"
               id="my-logs-table">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    {{__('label.event')}}
                </th>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    {{__('label.created_at')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{__('label.ip_address')}}
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($audits as $audit)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <td class="px-6 py-4">{{ ucfirst($audit->event) }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($audit->created_at)->format('Y-m-d H:i:s') }}</td>
                    <td class="px-6 py-4">{{ $audit->ip_address }}</td>
                    <td class="px-6 py-4">{{ $audit->user_email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No audit records found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

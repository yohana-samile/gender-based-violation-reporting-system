@extends('layouts.backend.app')
@section('title', 'User Activity')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <h1 class="text-xl font-bold text-gray-800">
                {{ __('Caused activity') }}
                <span class="mt-2 text-gray-600 text-sm">
                    ({{ $user->email ?? 'Unknown User' }})
                </span>
            </h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600" id="my-logs-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{__('Event')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('Created At')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('IP Address')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('User Email')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($audits as $audit)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ ucfirst($audit->event) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($audit->created_at)->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $audit->ip_address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $audit->user_email }}
                        </td>
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
    </div>
@endsection

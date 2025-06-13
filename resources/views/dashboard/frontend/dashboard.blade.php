@extends('layouts.frontend.mainlayout')
@section('title', 'Dashboard')
@section('content')
@php
    $emailCount = \App\Models\EmailManager::query()->where('admin_id', user_id())->count();
    $domainCount = \App\Models\DomainUser::query()->where('user_id', user_id())->count();
    $totalMileStone = 1000;
@endphp
    @if (access()->allow('manage_emails'))
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <x-widget
                :value="$emailCount"
                description="Total Emails Registered"
                :progress="100 * $emailCount / $totalMileStone"
                :hint="($totalMileStone - $emailCount) . ' more until next milestone.'"
                bgColor="bg-blue-500"
            />

            <x-widget
                :value="$domainCount"
                description="Total Domains Registered"
                :progress="100 * $domainCount / $totalMileStone"
                :hint="(1000 - $domainCount) . ' more until next milestone.'"
                bgColor="bg-green-500"
            />
        </div>
    @endif
@endsection

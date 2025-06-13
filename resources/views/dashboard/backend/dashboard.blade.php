@extends('layouts.backend.mainlayout')
@section('title', 'Dashboard')
@section('content')
    @php
        $incident = \App\Models\Incident::count();
        $Victim = \App\Models\Victim::count();
        $adminCount = \App\Models\Access\User::where('is_super_admin', false)->count();
        $totalMileStone = 1000;
    @endphp
    @if (access()->allow('all'))
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <x-widget
                    :value="$incident"
                    description="Total Incident"
                    :progress="100 * $incident / $totalMileStone"
                    :hint="($totalMileStone - $incident) . ' more until next milestone.'"
                    bgColor="bg-blue-500"
            />

            <x-widget
                    :value="$Victim"
                    description="Total Victims"
                    :progress="100 * $Victim / $totalMileStone"
                    :hint="(1000 - $Victim) . ' more until next milestone.'"
                    bgColor="bg-green-500"
            />

            <x-widget
                    :value="$adminCount"
                    description="Total Admins Registered"
                    :progress="100 * $adminCount / $totalMileStone"
                    :hint="(1000 - $adminCount) . ' more until next milestone.'"
                    bgColor="bg-red-400"
            />
        </div>
    @endif
@endsection

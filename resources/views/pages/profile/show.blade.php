@extends('layouts.mainlayout')
@section('title', 'Profile')
@section('content')
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
            <x-section-border/>
            <div class="mt-10 sm:mt-0">
                <livewire:update-password-form/>
            </div>

            <x-section-border/>
            <div class="mt-10 sm:mt-0">
                <livewire:update-profile-information/>
            </div>

            <x-section-border/>
            <div class="mt-10 sm:mt-0">
                <livewire:logout-other-browser-sessions-form/>
            </div>

            <x-section-border/>
            <div class="mt-10 sm:mt-0">
                <livewire:two-factor-authentication-form/>
            </div>

            {{-- delete my account --}}
        </div>
    </div>
@endsection

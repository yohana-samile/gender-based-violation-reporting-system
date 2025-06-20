@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Incident') }}
    </h2>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('incidents.update', $incident->uid) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-8">
                            <h3 class="text-lg font-medium mb-4">Incident Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="title"
                                           value="{{ old('title', $incident->title) }}" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select name="type" id="type" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select incident type</option>
                                        @foreach($incidentTypes as $type)
                                            <option
                                                value="{{ $type->name }}" {{ old('type', $incident->type) === $type->name ? 'selected' : '' }}> {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="occurred_at" class="block text-sm font-medium text-gray-700">Date &
                                        Time</label>
                                    <input type="datetime-local" name="occurred_at" id="occurred_at"
                                           value="{{ old('occurred_at', $incident->occurred_at->format('Y-m-d\TH:i')) }}"
                                           required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="location"
                                           class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location"
                                           value="{{ old('location', $incident->location) }}" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                @if (access()->allow('case_worker'))
                                    <div>
                                        <label for="status"
                                               class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status" required
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select incident status</option>
                                            @foreach($incidentStatus as $status)
                                                <option
                                                    value="{{ $status->name }}" {{ old('status', $incident->status) === $status->name ? 'selected' : '' }}> {{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                           {{ old('is_anonymous', $incident->is_anonymous) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                                        Report anonymously
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="description"
                                       class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $incident->description) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Incident
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

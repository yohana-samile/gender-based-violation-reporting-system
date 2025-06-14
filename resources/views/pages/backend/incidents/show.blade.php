@extends('layouts.backend.mainlayout')
@section('title', 'View Incident')
@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full ">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 pb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between w-full">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $incident->title }}</h2>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $incident->status === 'reported' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $incident->status === 'under_investigation' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $incident->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $incident->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                </span>
                                <p class="text-sm text-gray-600">
                                    <i class="far fa-calendar-alt mr-1"></i> Reported on {{ $incident->created_at->format('M d, Y \a\t h:i A') }}
                                    @if($incident->is_anonymous)
                                        <span class="ml-2"><i class="far fa-user-secret mr-1"></i>Anonymous Report</span>
                                    @else
                                        <span class="ml-2"><i class="far fa-user mr-1"></i>by {{ $incident->reporter->name }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-shrink-0 space-x-4">
                            @if (access()->allow('case_worker'))
                                <a href="{{ route('backend.incident.edit', $incident->uid) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="far fa-edit mr-2"></i> Edit
                                </a>
                            @endif
                            <a href="{{ route('backend.incident.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <i class="far fa-arrow-left mr-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 w-full">
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
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 w-full">
                        <!-- Left Column (Main Content) -->
                        <div class="lg:col-span-2 space-y-6 w-full">
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-info-circle text-blue-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Incident Details</h3>
                                </div>
                                <div class="prose max-w-none text-gray-700 whitespace-pre-line bg-gray-50 p-4 rounded">
                                    {{ $incident->description }}
                                </div>
                            </div>

                            <!-- Key Information Card -->
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-key text-indigo-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Key Information</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</h4>
                                        <p class="text-gray-900 font-medium capitalize flex items-center">
                                            <i class="fas fa-tag text-gray-400 mr-2 text-sm"></i>
                                            {{ str_replace('_', ' ', $incident->type) }}
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Occurred</h4>
                                        <p class="text-gray-900 font-medium flex items-center">
                                            <i class="far fa-calendar text-gray-400 mr-2 text-sm"></i>
                                            {{ $incident->occurred_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Location</h4>
                                        <p class="text-gray-900 font-medium flex items-center">
                                            <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-sm"></i>
                                            {{ $incident->location }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Victims Section -->
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-red-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-user-shield text-red-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Victim(s) Information</h3>
                                </div>
                                <div class="space-y-4">
                                    @foreach($incident->victims as $victim)
                                        <div class="border border-gray-200 p-5 rounded-lg hover:shadow-md transition-shadow duration-200">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="space-y-3">
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</h5>
                                                        <p class="mt-1 text-sm text-gray-900">{{ $victim->name ?? 'Not provided' }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gender</h5>
                                                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ $victim->gender }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Age</h5>
                                                        <p class="mt-1 text-sm text-gray-900">{{ $victim->age ?? 'Not provided' }}</p>
                                                    </div>
                                                </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Vulnerability</h5>
                                                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ $victim->vulnerability ?? 'Not specified' }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact Number</h5>
                                                        <p class="mt-1 text-sm text-gray-900">{{ $victim->contact_number ?? 'Not provided' }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact Email</h5>
                                                        <p class="mt-1 text-sm text-gray-900">{{ $victim->contact_email ?? 'Not provided' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($victim->address)
                                                <div class="mt-4 pt-4 border-t border-gray-100">
                                                    <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Address</h5>
                                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $victim->address }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Perpetrators Section -->
                            @if($incident->perpetrators->isNotEmpty())
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-orange-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-user-slash text-orange-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Perpetrator(s) Information</h3>
                                    </div>
                                    <div class="space-y-4">
                                        @foreach($incident->perpetrators as $perpetrator)
                                            <div class="border border-gray-200 p-5 rounded-lg hover:shadow-md transition-shadow duration-200">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="space-y-3">
                                                        <div>
                                                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</h5>
                                                            <p class="mt-1 text-sm text-gray-900">{{ $perpetrator->name ?? 'Unknown' }}</p>
                                                        </div>
                                                        <div>
                                                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gender</h5>
                                                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $perpetrator->gender }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-3">
                                                        <div>
                                                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Age</h5>
                                                            <p class="mt-1 text-sm text-gray-900">{{ $perpetrator->age ?? 'Unknown' }}</p>
                                                        </div>
                                                        <div>
                                                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Relationship to Victim</h5>
                                                            <p class="mt-1 text-sm text-gray-900">{{ $perpetrator->relationship_to_victim ?? 'Not specified' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($perpetrator->description)
                                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</h5>
                                                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $perpetrator->description }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Evidence Section -->
                            @if($incident->evidence->isNotEmpty())
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-camera-retro text-purple-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Evidence</h3>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($incident->evidence as $evidence)
                                            <div class="border border-gray-200 p-4 rounded-lg hover:shadow-md transition-shadow duration-200">
                                                <div class="flex justify-between items-start mb-3">
                                                    <div class="bg-gray-100 p-2 rounded">
                                                        @if(in_array($evidence->file_type, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <i class="far fa-image text-gray-500"></i>
                                                        @elseif(in_array($evidence->file_type, ['pdf']))
                                                            <i class="far fa-file-pdf text-red-500"></i>
                                                        @elseif(in_array($evidence->file_type, ['doc', 'docx']))
                                                            <i class="far fa-file-word text-blue-500"></i>
                                                        @else
                                                            <i class="far fa-file-alt text-gray-500"></i>
                                                        @endif
                                                    </div>
                                                    <a href="{{ Storage::url($evidence->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                                        <i class="fas fa-external-link-alt mr-1 text-xs"></i> View
                                                    </a>
                                                </div>
                                                @if($evidence->description)
                                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $evidence->description }}</p>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-2">File type: {{ strtoupper($evidence->file_type) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Support Services Section -->
                            @if($incident->supportServices->isNotEmpty())
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-hands-helping text-green-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Support Services</h3>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($incident->supportServices as $service)
                                            <div class="border border-gray-200 p-4 rounded-lg hover:shadow-md transition-shadow duration-200">
                                                <div class="flex items-start">
                                                    <div class="bg-blue-50 p-2 rounded mr-3">
                                                        <i class="fas fa-phone-alt text-blue-500"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="text-sm font-medium text-gray-700">{{ $service->name }}</h5>
                                                        <p class="text-xs text-gray-500 mb-1 capitalize">{{ $service->type }}</p>
                                                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                                                            <i class="fas fa-phone mr-2 text-xs text-gray-400"></i>{{ $service->contact_number }}
                                                        </p>
                                                        @if($service->pivot->notes)
                                                            <div class="mt-2 pt-2 border-t border-gray-100">
                                                                <p class="text-xs text-gray-500 mb-1">Notes:</p>
                                                                <p class="text-sm text-gray-600">{{ $service->pivot->notes }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Case Updates Section -->
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-history text-yellow-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Case Updates</h3>
                                </div>
                                <div class="space-y-4">
                                    @forelse($incident->updates as $update)
                                        <div class="relative pl-6 pb-4 border-l-2 border-blue-200">
                                            <div class="absolute -left-2 top-0 h-4 w-4 rounded-full bg-blue-500"></div>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $update->user->name }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            <i class="far fa-clock mr-1"></i>{{ $update->created_at->format('M d, Y \a\t h:i A') }}
                                                        </p>
                                                    </div>
                                                    @if($update->status_change)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            {{ $update->status_change === 'reported' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $update->status_change === 'under_investigation' ? 'bg-blue-100 text-blue-800' : '' }}
                                                            {{ $update->status_change === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $update->status_change === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $update->status_change)) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $update->update_text }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-6">
                                            <i class="far fa-comment-dots text-gray-300 text-3xl mb-2"></i>
                                            <p class="text-sm text-gray-500">No updates yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 w-full">
                            @if (access()->allow('case_worker'))
                                <!-- Update Status Card -->
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-sync-alt text-blue-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Update Status</h3>
                                    </div>
                                    <form action="{{ route('backend.incident.update-status', $incident->uid) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                                <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm nextbyte-select2">
                                                    <option value="">Select incident status</option>
                                                    @foreach($incidentStatus as $status)
                                                        <option value="{{ $status->name }}" {{ old('status', $incident->status) === $status->name ? 'selected' : '' }}> {{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="update_text" class="block text-sm font-medium text-gray-700 mb-1">Update Notes</label>
                                                <textarea name="update_text" id="update_text" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add update notes..." required></textarea>
                                            </div>
                                            <button type="submit" class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <i class="fas fa-save mr-2"></i> Update Status
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-link text-green-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Attach Support Services</h3>
                                    </div>
                                    <form action="{{ route('backend.incident.attach-services', $incident->uid) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div class="mb-4">
                                                <label for="service_ids" class="block text-sm font-medium text-gray-700 mb-1">Services</label>
                                                <select
                                                    name="service_ids[]"
                                                    id="service_ids"
                                                    multiple
                                                    class="mt-1 block w-full"
                                                >
                                                    @foreach($supportServices as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->type }})</option>
                                                    @endforeach
                                                </select>
                                                <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple</p>
                                            </div>
                                            <div>
                                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                                <textarea name="notes" id="notes" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add notes about services..."></textarea>
                                            </div>
                                            <button type="submit" class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <i class="fas fa-paperclip mr-2"></i> Attach Services
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-clipboard-list text-indigo-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Incident Summary</h3>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Reported</span>
                                        <span class="text-sm font-medium">{{ $incident->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Occurred</span>
                                        <span class="text-sm font-medium">{{ $incident->occurred_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Victims</span>
                                        <span class="text-sm font-medium">{{ $incident->victims->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Perpetrators</span>
                                        <span class="text-sm font-medium">{{ $incident->perpetrators->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Evidence Items</span>
                                        <span class="text-sm font-medium">{{ $incident->evidence->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Support Services</span>
                                        <span class="text-sm font-medium">{{ $incident->supportServices->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Case Updates</span>
                                        <span class="text-sm font-medium">{{ $incident->updates->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-styles')
    <style>
        .prose {
            line-height: 1.6;
        }
    </style>
@endpush

@push('after-scripts')
    <script>
        new TomSelect('#service_ids', {
            plugins: ['remove_button'],
            maxItems: null,
            placeholder: 'Select services...',
            render: {
                option: function(data, escape) {
                    return '<div class="flex items-center">' + escape(data.text) + '</div>';
                },
            }
        });
    </script>
@endpush

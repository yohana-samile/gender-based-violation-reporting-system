@extends('layouts.backend.app')
@section('title', __('Log Viewer'))

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <h1 class="text-2xl font-bold mr-4">{{ __('Log File') }}: {{ $fileName }}</h1>
            <a href="{{ route('backend.logs.index') }}" class="text-blue-600 hover:text-blue-900">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to logs') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4 gap-4">
                        <button id="expand-all" class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="fas fa-expand mr-1"></i> {{ __('Expand All') }}
                        </button>
                        <button id="collapse-all" class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="fas fa-compress mr-1"></i> {{ __('Collapse All') }}
                        </button>
                        <a href="{{ route('backend.logs.download', $fileName) }}"
                           class="text-green-600 hover:text-green-900"><i
                                    class="fa fa-download"></i> {{__('Download')}}</a>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ count($groupedLogs) }} {{ __('log groups') }}
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200" id="log-accordion">
                @foreach($groupedLogs as $index => $group)
                    <div class="log-group">
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-50 group-toggle"
                                data-target="#log-group-{{ $index }}">
                            <div class="flex justify-between items-center">
                                <div class="font-medium text-gray-900">
                                    <span class="text-blue-500 mr-2">
                                        <i class="fas fa-clock"></i> {{ $group['formatted_time'] }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">
                                        {{ count($group['messages']) }} {{ __('messages') }}
                                    </span>
                                </div>
                                <div class="text-gray-500 transform transition-transform duration-200">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </button>

                        <div id="log-group-{{ $index }}" class="log-content px-4 pb-3 hidden">
                            <div class="bg-gray-50 rounded p-3">
                                <pre class="text-sm font-mono text-gray-800 whitespace-pre-wrap max-h-96 overflow-y-auto">
                                   @foreach($group['messages'] as $message)
                                        {{ $group['log_timestamp'] }} {{ $message }}
                                    @endforeach
                                </pre>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .log-group pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle individual groups
            document.querySelectorAll('.group-toggle').forEach(button => {
                button.addEventListener('click', function () {
                    const target = this.dataset.target;
                    const content = document.querySelector(target);
                    const icon = this.querySelector('i.fa-chevron-down');

                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Expand all groups
            document.getElementById('expand-all').addEventListener('click', function () {
                document.querySelectorAll('.log-content').forEach(el => {
                    el.classList.remove('hidden');
                });
                document.querySelectorAll('.group-toggle i.fa-chevron-down').forEach(icon => {
                    icon.classList.add('rotate-180');
                });
            });

            // Collapse all groups
            document.getElementById('collapse-all').addEventListener('click', function () {
                document.querySelectorAll('.log-content').forEach(el => {
                    el.classList.add('hidden');
                });
                document.querySelectorAll('.group-toggle i.fa-chevron-down').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });
            });
        });
    </script>
@endpush

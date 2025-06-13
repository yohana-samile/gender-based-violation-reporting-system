@extends('layouts.backend.mainlayout')
@section('title', __('roles permissions'))

@section('content')
    <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-6">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="mr-2" role="presentation">
                    <a href="#general_tab" class="inline-block p-4 border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 dark:border-blue-400 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                        {{ __('general') }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content text-gray-700 dark:text-gray-200">
            <div class="tab-pane active show" id="general_tab" role="tabpanel">
                <div class="mb-4 flex justify-end">
                    @if(access()->allow('manage_role_and_permissions'))
                        <a href="{{ route('backend.role.edit', $role->uid) }}"
                           class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 dark:hover:bg-blue-500 mr-2">
                            <i class="ri-pencil-fill mr-2 text-white"></i> {{ __('Edit') }}
                        </a>

                        @if($role->checkIfCanBeDeleted())
                            {!! link_to_route('backend.role.delete', trans('label.crud.delete'),
                                [$role->uid], [
                                    'data-method' => 'delete',
                                    'data-trans-button-cancel' => trans('buttons.general.cancel'),
                                    'data-trans-button-confirm' => trans('buttons.general.confirm'),
                                    'data-trans-title' => trans('warning'),
                                    'data-trans-text' => trans('Delete'),
                                    'class' => 'inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 dark:hover:bg-red-500 mr-2'
                                ])
                            !!}
                        @endif
                    @endif

                    <a href="{{ route('backend.role.index') }}"
                       class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-gray-700 dark:hover:bg-gray-500">
                        <i class="ri-close mr-2 text-white"></i> {{ __('Close') }}
                    </a>
                </div>

                @include('pages.backend.access.role.profile.includes.general_info')
            </div>

            <div class="tab-pane hidden" id="document_center_tab" role="tabpanel">
                <div class="flex">
                </div>
            </div>
        </div>
    </div>
@endsection

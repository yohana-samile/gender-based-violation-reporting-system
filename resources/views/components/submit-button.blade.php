<div class="flex items-center justify-end space-x-3 mt-4 mb-3 gap-4">
    <div>
        @if ($showClose)
            @if ($closeType === 'modal')
                <button type="button" onclick="closeModal('{{ $closeTarget }}')" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mb-3">
                    <i class="fas fa-times"></i> {{ __('label.action_crud.close') }}
                </button>
            @elseif ($closeType === 'route' && $closeTarget)
                <a href="{{ $closeTarget }}" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mb-3">
                    <i class="fas fa-home"></i> {{ __('label.action_crud.back') }}
                </a>
            @endif
        @endif
    </div>

    <div>
        <button type="submit" id="{{ $buttonId ?? 'submit_btn' }}" class="{{ $buttonClass }} text-white px-4 py-2 rounded float-end">
            @if ($icon)
                <i class="{{ $icon }}"></i>
            @endif
            <span id="{{ $labelId ?? 'submit_label' }}">{{ __($label) }}</span>
        </button>
    </div>
</div>

{{--usage --}}
{{--<x-submit-button icon="fas fa-save" label="label.action_crud.save" />--}}
{{--<x-submit-button class="bg-red-500 text-white px-4 py-2 rounded mt-4 mb-3 float-end" icon="fas fa-save" label="label.resynchronization" />--}}

{{--<x-submit-button--}}
{{--    icon="fas fa-edit"--}}
{{--    label="label.action_crud.update"--}}
{{--    :showClose="true"--}}
{{--    closeType="modal"--}}
{{--    closeTarget="editModalId" />--}}

{{--<x-submit-button--}}
{{--    icon="fas fa-check"--}}
{{--    label="Submit and Go Back"--}}
{{--    :showClose="true"--}}
{{--    closeType="route"--}}
{{--    closeTarget="home" />--}}


    @if (session()->get('flash_success'))
        <div class="alert alert-success" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(is_array(json_decode(session()->get('flash_success'), true)))
                {!! implode('', session()->get('flash_success')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_success') !!}
            @endif
        </div>
    @endif
    @if (session()->get('flash_info'))
        <div class="alert alert-info" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(is_array(json_decode(session()->get('flash_info'), true)))
                {!! implode('', session()->get('flash_info')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_info') !!}
            @endif
        </div>
    @endif
    @if (session()->get('flash_warning'))
        <div class="alert alert-warning" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(is_array(json_decode(session()->get('flash_warning'), true)))
                {!! implode('', session()->get('flash_warning')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_warning') !!}
            @endif
        </div>
    @endif
    @if (session()->get('flash_danger'))
        <div class="alert alert-danger" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(is_array(json_decode(session()->get('flash_danger'), true)))
                {!! implode('', session()->get('flash_danger')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_danger') !!}
            @endif
        </div>
    @endif
    @if (session()->get('flash_message'))
        <div class="alert alert-default" role="alert" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @if(is_array(json_decode(session()->get('flash_message'), true)))
                {!! implode('', session()->get('flash_message')->all(':message<br/>')) !!}
            @else
                {!! session()->get('flash_message') !!}
            @endif
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ __('exceptions.general.error') }}
        </div>
    @endif

    <script>
        setTimeout(() => {
            document.getElementById('alert')?.remove();
        }, 5000);
    </script>

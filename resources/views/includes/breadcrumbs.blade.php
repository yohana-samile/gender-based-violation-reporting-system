

@unless ($breadcrumbs->isEmpty())

    <ol class="breadcrumb float-xs-right  ">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                {{--<li class="breadcrumb-item"><span class="fs1" aria-hidden="true" data-icon=""></span>
                    <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </li>--}}
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>

@endunless

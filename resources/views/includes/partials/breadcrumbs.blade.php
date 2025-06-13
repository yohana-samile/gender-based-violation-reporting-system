@unless ($breadcrumbs->isEmpty())
    <ol class="flex flex-wrap space-x-2 text-sm text-gray-700 justify-end">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li>
                    <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:underline">
                        {{ $breadcrumb->title }}
                    </a>
                    <span class="mx-1 text-gray-400">/</span>
                </li>
            @else
                <li class="text-gray-500">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endunless

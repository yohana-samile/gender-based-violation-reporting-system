<div class="p-4 rounded-lg shadow-lg text-white {{ $bgColor }}">
    <div class="text-2xl font-bold">{{ $value }}</div>
    <div class="text-sm">{{ $description }}</div>
    @if($progress !== null)
        <div class="w-full bg-gray-200 rounded-full mt-2">
            <div class="h-2 rounded-full bg-white" style="width: {{ $progress }}%;"></div>
        </div>
        <div class="text-xs mt-1">{{ $hint }}</div>
    @endif
</div>

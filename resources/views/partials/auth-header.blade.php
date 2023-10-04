<div class="text-center">
    <h1 class="text-2xl leading-10 font-semibold tracking-tight">{{ $title }}</h1>

    @if($subtitle ?? false)
    <p class="mt-4 leading-10 font-medium text-md text-center">{{ $subtitle }}</p>
    @endif

    @if($info ?? false)
    <p class="mt-4">{{ $info }}</p>
    @endif

    @if($badge ?? false)
    <div class="mt-4 inline-block bg-green-light text-xs px-1.5 py-0.5 rounded-full uppercase font-semibold">
        Beta Launch
    </div>
    @endif
</div>
<div class="text-center font-semibold">
    <h1 class="text-xl tracking-tight">{{ $title }}</h1>

    @if($subtitle ?? false)
    <p class="leading-10 font-medium text-md text-center">{{ $subtitle }}</p>
    @endif

    @if($info ?? false)
    <p class="mt-4">{{ $description }}</p>
    @endif

    @if($badge ?? false)
    <div class="mt-4 inline-block bg-green-light text-xs px-1.5 py-0.5 rounded-full uppercase">
        Beta Launch
    </div>
    @endif
</div>
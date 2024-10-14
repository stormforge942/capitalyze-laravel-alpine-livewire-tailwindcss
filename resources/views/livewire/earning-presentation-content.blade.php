<x-wire-elements-pro::tailwind.slide-over>
    <div class="relative h-full" x-data="{ isLoading: true }">
        <div class="h-full">
            <!-- Display loading state while the iframe is loading -->
            <div x-show="isLoading" class="flex items-center justify-center h-full">
                <div class="py-10 w-full">
                    <div class="w-full flex justify-center">
                        <div class="simple-loader !text-green-dark"></div>
                    </div>
                </div>
                <span class="sr-only">Loading...</span>
            </div>

            @if ($sourceLink)
                <iframe src="{{ route('pdf-viewer', ['sourceLink' => $sourceLink]) }}" class="w-full h-full"
                    frameborder="0" @load="isLoading = false">
                    Your browser does not support iframes. Please download the PDF to view it:
                    <a href="{{ route('pdf-viewer', ['sourceLink' => $sourceLink]) }}">Download PDF</a>
                </iframe>
            @else
                <p>No PDF available.</p>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>

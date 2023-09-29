<p class="text-lg mb-2 font-semibold">There is a potential issue with this data:</p>

<ul class="space-y-1">
    @foreach ($errors as $error)
    <li>{{ $error['date'] }}, {{ $error['segment'] }}: {{ $error['value'] }}</li>
    @endforeach
</ul>

<p class="mt-2 text-gray-700">
    please contact <a href="mailto:data@capitalyze.com" class="underline" target="_blank">data@capitalyze.com</a> for review
</p>
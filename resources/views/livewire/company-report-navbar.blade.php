<div>
<div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            @foreach(array_keys($navbar) as $value)
                <li class="inline-block p-4 border-b-2 rounded-t-lg @if($value == $activeIndex)text-blue-600 active border-b-2 border-blue-600 @else cursor-pointer border-transparent hover:text-gray-600 hover:border-gray-300 @endif" wire:click="$emit('tabClicked', '{{$value}}')">{{ preg_replace('/\[[^\]]*?\]/', '', $value) }}</li>
            @endforeach
        </ul>
    </div>
</div>
<div class="px-2 py-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
    <div class="pb-2 pl-4 text-sm font-medium text-left text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <label for="face-select"> Segment : </label>
        <select id="face-select" class="inline-flex px-3 py-2 pr-8 leading-tight border rounded appearance-none bg-slate-50 border-slate-300 text-slate-700 focus:outline-none focus:bg-white focus:border-slate-500" wire:change="$emit('tabSubClicked', $event.target.value)">
            @foreach($navbar[$activeIndex] as $key => $value)
                <option value="{{ $value['id'] }}" @if($value['id'] == $activeSubIndex)selected @endif>{{ preg_replace('/\[[^\]]*?\]/', '',$value['title']) }}</option>
            @endforeach
        </select>
    </div>
</div>
</div>
<div class="w-100" x-data="{
    updateSetting(key, value) {
        this.$wire.updateSetting(key, value);
    }
}">
    <div class="flex flex-col">
        <span class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Notification Settings</span>
        <span class="text-[#2575F0] block mt-2 px-3">Set default table options for the financial table</span>
    </div>

    <div class="mt-3 px-3">
        @foreach ($columns as $key => $column)
            <div class="flex items-center justify-between py-5 border-b">
                <div>
                    <h6 class="text-md font-semibold mb-1">{{ $column['text'] }}</h6>
                    <p class="text-sm text-gray-500">{{ $column['type'] }}</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        class="sr-only peer"
                        type="checkbox"
                        @change="updateSetting('{{ $key }}', $event.target.checked)"
                        {{ isset($settings[$key]) && $settings[$key] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-100 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                </label>
            </div>
        @endforeach
    </div>
</div>

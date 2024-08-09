<div class="w-100" x-data="{
    isShowingLogs: false,
}">
    <div class="flex items-center justify-between">
        <span x-show="!isShowingLogs" class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Security</span>
        <button x-show="isShowingLogs" class="flex" @click="isShowingLogs = false;">
            <img class="mr-2" src="{{ asset('svg/left.svg') }}" alt="Left Icon" />
            <span class="underline font-bold">Go Back</span>
        </button>
    </div>

    <div class="mt-3 px-3">
        <template x-if="!isShowingLogs">
            <div class="flex items-center justify-between py-3 border-b">
                <div>
                    <h6 class="text-md font-semibold mb-1">Activity Logs</h6>
                    <p class="text-sm text-gray-500">Track activity logs of team members</p>
                </div>
                <button class="bg-green-100 text-green-700 px-4 py-1 rounded font-bold" @click="isShowingLogs = true;">Modify</button>
            </div>
        </template>
        
        <template x-if="isShowingLogs">
            <div class="mt-6 overflow-x-auto">
                <table class="table power-grid-table w-full bg-white rounded-md overflow-clip">
                    <thead class="font-sm font-semibold capitalize bg-[#EDEDED] rounded-t-md">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="pl-6 py-2 text-dark whitespace-nowrap"
                                    :style="`width: max-content;`">
                                    <div class="flex @if($column['center'] ?? false) justify-center @endif" >
                                        <div class="inline-flex items-center gap-1">
                                            {{ $column['name'] }}
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y-2">
                        @if (count($logs))
                            @foreach ($logs as $log)
                                @php
                                    $createdAt = $log['created_at'] ? formatDateTime(new DateTime($log['created_at'])) : '';
                                @endphp
                                <tr>
                                    <td class="pl-6 whitespace-nowrap py-3">{{ $log['user']['name'] }} </td>
                                    <td class="pl-6 whitespace-nowrap">{{ $log['activity'] }}</td>
                                    <td class="pl-6 whitespace-nowrap">{{ $log['description'] . ' on ' . $createdAt }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </template>
    </div>
</div>

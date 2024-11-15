<div
    class="bg-white rounded border-[0.5px] border-[#D4DDD7] px-4 py-6 overflow-hidden">
    <div class="flex items-center justify-between gap-2">
        <a href="{{ route('company.adviser', ['adviser' => $adviser['legal_name'], 'tab' => 'holdings', 'from' => 'track-investors']) }}"
            class="text-blue font-semibold capitalize hover:underline">
            {{ $adviser['legal_name'] }}
        </a>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-x-6 md:gap-x-8 gap-y-4">
        <div>
            <label class="font-normal text-sm text-dark-light2">Assets</label>
            <div class="font-semibold text-base break-all">{{ niceNumber($adviser['assets_under_management']) }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">Number of Employees</label>
            <div class="font-semibold text-base break-all">{{ $adviser['number_of_employees'] }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">Number of Accounts</label>
            <div class="font-semibold text-base break-all">{{ $adviser['number_of_accounts'] }}</div>
        </div>
        <div>
            <label class="font-normal text-sm text-dark-light2">CIK</label>
            <div class="font-semibold text-base break-all">
                {{ $adviser['cik'] ?? '--' }}
            </div>
        </div>
    </div>
</div>

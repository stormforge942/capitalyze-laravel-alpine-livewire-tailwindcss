<div class="flex flex-col h-full">
    <div class="bg-white p-6">
        <div class="block mx-auto text-xl text-center">Revoke device</div>
        <span class="mt-4 mx-auto block text-center">Are you sure you want to revoke <b>{{ $platform }}</b>? You will be automatically logged out of this device</span>
        
        <div class="grid grid-cols-12 gap-x-4 mt-4">
            <button wire:click="cancelRevocation" class="col-span-6 block w-full text-center mt-4 py-2 bg-gray-500 text-white font-semibold rounded">
                Cancel
            </button>
            <button @click="$dispatch('device-revoke', { sessionId: '{{ $sessionId }}' })" wire:click="cancelRevocation" class="col-span-6 block w-full text-center mt-4 py-2 bg-red-500 text-white font-semibold rounded">
                Revoke Device
            </button>
        </div>
    </div>
</div>
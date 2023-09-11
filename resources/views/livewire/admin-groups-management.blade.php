<div class="py-12">
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-2/3 md:mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Groups Management</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <div>Create New Group</div>
                <input type="text" placeholder="Group Name" wire:change="createGroup($event.target.value)">
                <table class="table-auto w-full overflow-scroll" wire:loading.remove>
                    <thead>
                        <tr>
                            <td class="font-semibold py-4">ID</td>
                            <td class="font-semibold py-4">Name</td>
                            <td class="font-semibold py-4">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                        <tr>
                            <td class="font-semibold py-4">{{ $group->id }}</td>
                            <td class="font-semibold py-4">{{ $group->name }}</td>
                            <td>
                                <button wire:click="deleteGroup({{ $group->id }})" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
                                    <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Delete User Confirmation Modal -->
<x-jet-dialog-modal wire:model="confirmingGroupDeletion" wire:ignore>
    <x-slot name="title">
        {{ __('Confirm Group Deletion') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to delete this group?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('confirmingGroupDeletion', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button wire:click="performGroupDeletion" wire:loading.attr="disabled">
            {{ __('Delete Group') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>
</div>

@push('scripts')
<script>
    window.addEventListener('swal:confirming-group-deletion', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.type,
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: event.detail.confirmButtonText,
            cancelButtonText: event.detail.cancelButtonText,
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('performGroupDeletion');
            }
        });
    });
</script>
@endpush

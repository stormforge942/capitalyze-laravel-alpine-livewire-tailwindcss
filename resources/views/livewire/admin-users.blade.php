<div class="py-12">
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-2/3 md:mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">User management</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <table class="table-auto min-w-full border-collapse">
                    <thead>
                        <tr>
                            <th><a wire:click.prevent="sortBy('id')">ID</a></th>
                            <th><a wire:click.prevent="sortBy('name')">Name</a></th>
                            <th><a wire:click.prevent="sortBy('email')">Email</a></th>
                            <th><a wire:click.prevent="sortBy('email')">Group</a></th>
                            <th><a wire:click.prevent="sortBy('approved')">Approved</a></th>
                            <th><a wire:click.prevent="sortBy('created_at')">Registration Date</a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr class="{{ $index % 2 ? 'bg-gray-200' : '' }}"> <!-- Alternating row colors -->
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">
                                <select wire:change="updateUserGroup('{{ $user->id }}', $event.target.value)">
                                    <option value="admin" @if ($user->group === 'admin') selected @endif>Admin</option>
                                    <option value="user" @if ($user->group === 'user') selected @endif>User</option>
                                    <option value="developer" @if ($user->group === 'developer') selected @endif>Developer</option>
                                    <option value="tester" @if ($user->group === 'tester') selected @endif>Tester</option>
                                </select>
                            </td>
                            <td class="text-center">{{ $user->is_approved ? 'Yes' : 'No' }}</td>
                            <td class="text-center">{{ $user->created_at->format('m/d/Y') }}</td>
                            <td class="text-center">
                                @if(!$user->is_approved)
                                <button wire:click="approveUser({{ $user->id }})" class="mx-auto bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600"> <!-- Green Approve button -->
                                    <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
</svg> Approve
                                </button>
                                @else
                                <button wire:click="disapproveUser({{ $user->id }})" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600"> <!-- Red Disapprove button -->
                                    <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>
 Disapprove
                                </button>
                                @endif
                            </td>
                            <td class="text-center">
                                <button wire:click="deleteUser({{ $user->id }})" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
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

                {{ $users->links() }}
            </div>
        </div>
    </div>



<!-- Delete User Confirmation Modal -->
<x-jet-dialog-modal wire:model="confirmingUserDeletion" wire:ignore>
    <x-slot name="title">
        {{ __('Confirm User Deletion') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to delete this user?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button wire:click="performUserDeletion" wire:loading.attr="disabled">
            {{ __('Delete User') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>
</div>
@push('scripts')
<script>
    window.addEventListener('swal:confirming-user-deletion', event => {
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
                Livewire.emit('performUserDeletion');
            }
        });
    });
</script>
@endpush


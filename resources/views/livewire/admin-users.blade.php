<div class="py-6">
    <div class="flex px-4 sm:px-6 bg-white lg:px-8 py-4 shadow rounded max-w-5xl mx-auto">
        <div class="mt-8 flow-root rounded-lg overflow-x-auto">
            <table class="table-auto min-w-full border-collapse text-left" x-data>
                <thead>
                    <tr>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('id')">ID</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('name')">Name</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('email')">Email</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('email')">Is Admin</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('email')">Group</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('approved')">Approved</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('created_at')">Registration Date</a></th>
                        <th colspan="2" class="capitalize p-2 whitespace-nowrap bg-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($users as $index => $user)
                        <tr class="{{ $index % 2 ? 'bg-gray-200' : '' }}"> <!-- Alternating row colors -->
                            <td class="whitespace-nowrap p-2">{{ $user->id }}</td>
                            <td class="whitespace-nowrap p-2">{{ $user->name }}</td>
                            <td class="whitespace-nowrap p-2">{{ $user->email }}</td>
                            <td class="p-2">
                                <input type="checkbox" class="disabled:opacity-50"
                                    @change="$wire.updateIsAdmin({{ $user->id }}, $el.checked)"
                                    @if ($user->is_admin) checked @endif
                                    @if ($user->id === auth()->id()) disabled @endif>
                            </td>
                            <td class="p-2">
                                <select class="text-sm px-2 py-1 outline outline-1 outline-gray-500"
                                    wire:change="updateUserGroup('{{ $user->id }}', $event.target.value)">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}"
                                            @if ($user->group_id == $group->id) selected @endif>{{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2">{{ $user->is_approved ? 'Yes' : 'No' }}</td>
                            <td class="p-2">{{ $user->created_at->format('m/d/Y') }}</td>
                            <td class="p-2 text-left">
                                @if (!$user->is_approved)
                                    <button wire:click="approveUser({{ $user->id }})"
                                        class="w-full bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600 flex justify-center items-center gap-2 whitespace-nowrap">
                                        <!-- Green Approve button -->
                                        <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg> Approve
                                    </button>
                                @else
                                    <button wire:click="disapproveUser({{ $user->id }})"
                                        class="w-full bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 flex justify-center items-center gap-2 whitespace-nowraps">
                                        <!-- Red Disapprove button -->
                                        <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Disapprove
                                    </button>
                                @endif
                            </td>
                            <td>
                                <button wire:click="deleteUser({{ $user->id }})"
                                    class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 flex items-center gap-2 whitespace-nowrap">
                                    <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingUserDeletion" wire:ignore>
        <x-slot name="title">
            {{ __('Confirm User Deletion') }}
        </x-slot>

        <x-slot name="content">
            <p>
                Are you sure you want to delete this user ({{ $userToDelete?->email }})?
            </p>

            @if (auth()->id() === $userToDelete?->id)
                <p class="mt-4 text-yellow-600">
                    You are deleting yourself. This will log you out and you will not be able to log back in.
                </p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex gap-2">
                <x-jet-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button wire:click="performUserDeletion" wire:loading.attr="disabled">
                    {{ __('Delete User') }}
                </x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>

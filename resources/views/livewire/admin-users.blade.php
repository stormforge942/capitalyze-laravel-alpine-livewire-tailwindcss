<div class="py-6">
    <div class="warning-wrapper max-w-5xl mx-auto mb-3">
        <div class="warning-text text-sm">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.99967 14.6663C4.31777 14.6663 1.33301 11.6815 1.33301 7.99967C1.33301 4.31777 4.31777 1.33301 7.99967 1.33301C11.6815 1.33301 14.6663 4.31777 14.6663 7.99967C14.6663 11.6815 11.6815 14.6663 7.99967 14.6663ZM7.99967 13.333C10.9452 13.333 13.333 10.9452 13.333 7.99967C13.333 5.05415 10.9452 2.66634 7.99967 2.66634C5.05415 2.66634 2.66634 5.05415 2.66634 7.99967C2.66634 10.9452 5.05415 13.333 7.99967 13.333ZM7.33301 9.99967H8.66634V11.333H7.33301V9.99967ZM7.33301 4.66634H8.66634V8.66634H7.33301V4.66634Z"
                    fill="#DA680B" />
            </svg>
            All the date(time)s are in UTC timezone.
        </div>
    </div>

    <div class="px-4 sm:px-6 bg-white lg:px-8 py-4 shadow rounded max-w-5xl mx-auto">
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
                                wire:click.prevent="sortBy('email_verified_at')">Email Verified At</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('email_verified_at')">Last Activity At</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100"><a href="#"
                                wire:click.prevent="sortBy('created_at')">Registration Date</a></th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-100">Action</th>
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
                            <td class="p-2 whitespace-nowrap">
                                @if ($user->email_verified_at)
                                    {{ $user->email_verified_at->format('m/d/Y H:i') }}
                                @else
                                    <button
                                        class="border px-4 py-2 rounded-full bg-green-400 hover:bg-green-500 text-white font-semibold"
                                        wire:click="verifyUserEmail({{ $user->id }})">
                                        Verify
                                    </button>
                                @endif
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                @if ($user->last_activity_at)
                                    {{ $user->last_activity_at->format('m/d/Y H:i') }}
                                @else
                                    ---
                                @endif
                            </td>
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
                                <button wire:click="deleteUser({{ $user->id }})"
                                    class="mt-1 bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 flex items-center gap-2 whitespace-nowrap">
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

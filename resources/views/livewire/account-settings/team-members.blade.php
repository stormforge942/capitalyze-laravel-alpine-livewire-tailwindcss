<div x-data="{
    members: [],
    current: $wire.entangle('current', true),
    currentMember: null,
    newMembers: [],
    search: '',
    sortBy: 'asc',
    newMemberEmail: '',
    savingMember: false,

    init() {
        this.resolveMembers();
        this.resolveCurrentMember();

        this.$watch('search', () => this.resolveMembers());
        this.$watch('sortBy', () => this.resolveMembers());

        this.$watch('current', () => {
            window.updateQueryParam('current', this.current);

            this.resolveCurrentMember();
        });
    },

    resolveMembers() {
        this.members = @js($members);

        if (this.search) {
            this.members = this.members.filter(member => {
                return member.name.toLowerCase().includes(this.search.toLowerCase());
            })
        }

        this.members = this.members.sort((a, b) => {
            if (this.sortBy === 'asc') {
                return a.name.localeCompare(b.name);
            } else {
                return b.name.localeCompare(a.name);
            }
        });
    },

    resolveCurrentMember() {
        this.currentMember = this.members.find(member => member.id == this.current) || null;

        if (this.current && this.current !== 'new' && !this.currentMember) {
            this.current = '';
        }
    },

    formatDate(date) {
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        function getOrdinalSuffix(day) {
            if (day > 3 && day < 21) return 'th'; // 11th, 12th, 13th, etc.
            switch (day % 10) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
                default:
                    return 'th';
            }
        }

        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();

        const ordinalSuffix = getOrdinalSuffix(day);

        return `${day}${ordinalSuffix} ${month}, ${year}`;
    },

    formatDateTime(date, middle = ' ') {
        function formatTime(date) {
            let hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const strMinutes = minutes < 10 ? '0' + minutes : minutes;
            return `${hours}:${strMinutes}${ampm}`;
        }

        const time = formatTime(date);

        return `${this.formatDate(date)}${middle}${time} CET`;
    },

    updateRole(roleId) {
        $wire.updateRole(this.current, roleId);
    },

    removeMember() {
        $wire.removeMember(this.current);
    },

    addNewMember() {
        if (this.newMemberEmail == '') return;

        if (this.newMembers.some(member => member.email === this.newMemberEmail)) {
            this.newMemberEmail = ''
            return;
        }

        this.newMembers.push({
            email: this.newMemberEmail,
            role: 2,
            status: '',
        });

        fetch('/check-member', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: this.newMemberEmail })
            })
            .then(response => response.json())
            .then(data => {
                this.setNewMemberStatus(data.email, data.msg);
            })
            .catch(error => {
                console.log('Error checking member status:', error);
            });

        this.newMemberEmail = '';
    },

    setNewMemberStatus(email, value) {
        this.newMembers = this.newMembers.map(member => member.email === email ? {
            ...member,
            status: value
        } : member);
    },

    removeNewMember(idx) {
        this.newMembers.splice(idx, 1);
    },

    saveNewMembers() {
        if (this.saveMember) return;

        if (this.newMembers.some(member => member.role === '')) {
            alert('Please select a role for all new members');
            return;
        }

        this.savingMember = true;

        this.current = '';

        $wire.addMembers(this.newMembers)
            .then(() => {
                this.newMembers = [];
            })
            .finally(() => {
                this.savingMember = false;
            })
    }
}">
    <div class="flex items-center justify-between">
        <span x-show="!current" class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2"
            x-text="'Team Members (' + members.length + ')'"></span>
        <button x-show="current" class="flex" @click="current = '';">
            <img class="mr-2" src="{{ asset('svg/left.svg') }}" alt="Left Icon" />
            <span class="underline font-bold">Go Back</span>
        </button>
        <button x-show="!current"
            class="bg-[#52D3A2] text-black px-4 py-2 rounded font-semibold disabled:opacity-70 disabled:cursor-not-allowed"
            @click="current = 'new'"
            @if (!count($roles)) data-tooltip-content="You need to create roles before adding team member" @endif
            @disabled(!count($roles))>
            Add New Member
        </button>
        <button x-show="current == 'new' && newMembers.length"
            class="bg-[#52D3A2] text-black px-4 py-2 rounded font-semibold disabled:opacity-70 disabled:cursor-progress"
            @click="saveNewMembers()" x-text="savingMember ? 'Saving...' : 'Save'" :disabled="savingMember">
        </button>
    </div>

    <div class="mt-6">
        <template x-if="current === 'new'">
            <div>
                <h2 class="my-6 font-bold text-lg">Enter Email</h2>

                <form @submit.prevent="addNewMember" class="flex my-6">
                    <input class="border border-green-muted rounded px-4 mr-4 flex-1 placeholder:text-gray-medium2"
                        type="email" name="newMemberEmail" x-model="newMemberEmail" placeholder="Enter email" />
                    <button type="submit"
                        class="bg-green-light px-5 py-2 rounded flex items-center gap-3 font-semibold">
                        Add
                        <img src="{{ asset('svg/plus_circle.svg') }}" class="w-4 h-4" />
                    </button>
                </form>

                <div>
                    <div>
                        <template x-for="invitation in $wire.invitations" :key="invitation.id">
                            <div class="flex justify-between items-center border-b py-4 mb-3">
                                <div>
                                    <span x-text="invitation.email"></span> &nbsp;
                                    <div class="inline-block">
                                        <div class="flex flex-row items-center gap-x-1 text-black bg-[#E2E2E2] border-[1px] border-[#D4DDD7] p-2 rounded-full"
                                            style="max-width: 15rem">
                                            <span x-text="invitation.role.name"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row gap-x-6">
                                    <span class="text-[#DA680B]">Waiting for Acceptance</span>
                                    <button type="button" @click.prevent="$wire.deleteInvitation(invitation.id)">
                                        <img src="{{ asset('svg/close-cross-circle.svg') }}"
                                            class="w-6 h-6 cursor-pointer" alt="Delete" />
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div>
                        <template x-for="(member, idx) in newMembers" :key="member.email">
                            <div class="flex justify-between items-center border-b py-4 mb-3">
                                <div>
                                    <span x-text="member.email"></span> &nbsp;
                                    <x-select placeholder="Role" :options="$roles" x-model="member.role" nobutton="true"></x-select>
                                </div>
                                <div class="flex flex-row gap-x-6">
                                    <span class="text-[#DA680B]" x-text="member.status" x-show="member.status" x-cloak></span>
                                    <img @click="removeNewMember(idx)" src="{{ asset('svg/close-cross-circle.svg') }}"
                                        class="w-6 h-6 cursor-pointer" alt="Delete" />
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="currentMember">
            <div>
                <div class="w-[120px] h-[120px] text-[50px] my-5 mr-2">
                    <template x-if="currentMember?.profile_photo_path">
                        <img :src="currentMember?.profile_photo_path ? '{{ asset('storage/') }}' + '/' + currentMember
                            .profile_photo_path : ''"
                            class="rounded-full w-full h-full" />
                    </template>
                    <template x-if="!currentMember?.profile_photo_path">
                        <div class="bg-[#121A0F] text-[#DCF6EC] w-full h-full flex shrink-0 text-center items-center justify-center rounded-full"
                            x-text="currentMember?.initials">
                        </div>
                    </template>
                </div>
                <div class="flex items-center justify-between py-3 border-b my-4">
                    <div>
                        <h6 class="text-md font-semibold mb-1">Access Level</h6>
                        <p class="text-sm text-gray-500">View data in different formats</p>
                    </div>
                    <div>
                        <template x-if="currentMember?.isOwner">
                            <span
                                class="text-black bg-[#E2E2E2] border-[1px] border-[#D4DDD7] p-2 rounded-full">Admin</span>
                        </template>
                        <template x-if="!currentMember?.isOwner">
                            <x-select name="role" :options="$roles" x-model="currentMember.role_id" nobutton="true"
                                @selected="updateRole($event.detail.selected)" size="md"
                                color="#0000FF"></x-select>
                        </template>
                    </div>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Full Name</span>
                    <span class="text-black font-bold" x-text="currentMember?.name"></span>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Official Email</span>
                    <span class="text-black font-bold" x-text="currentMember?.email"></span>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Job Title</span>
                    <span class="text-black font-bold" x-text="currentMember?.job"></span>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Date of Birth</span>
                    <span class="text-black font-bold" x-text="currentMember?.dob"></span>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Country</span>
                    <span class="text-black font-bold" x-text="currentMember?.country"></span>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Company Socials</span>
                    <div class="flex gap-4">
                        <a x-bind:href="currentMember?.linkedin_link" x-show="currentMember?.linkedin_link"
                            target="_blank">
                            <img src="{{ asset('img/linkedin.png') }}"
                                style="height: 32px; width: 32px; border-radius: 50%; " alt="linkedin logo">
                        </a>
                        <a x-bind:href="currentMember?.facebook_link" x-show="currentMember?.facebook_link"
                            target="_blank">
                            <img src="{{ asset('img/facebook.png') }}"
                                style="height: 32px; width: 32px; border-radius: 50%; " alt="facebook logo">
                        </a>
                        <a x-bind:href="currentMember?.twitter_link" x-show="currentMember?.twitter_link"
                            target="_blank">
                            <img src="{{ asset('img/twitter.png') }}"
                                style="height: 32px; width: 32px; border-radius: 50%; " alt="twitter logo">
                        </a>
                    </div>
                </div>
                <div class="flex items-center justify-between border-b py-4 mb-3">
                    <span class="text-dark-light2">Last Activity</span>
                    <span class="text-black font-bold" x-text="currentMember?.last_activity_at"></span>
                </div>
                <div class="flex items-center justify-between py-3 border-b">
                    <div>
                        <h6 class="text-md font-semibold mb-1">Remove Account</h6>
                        <p class="text-sm text-[#DA680B]">You can remove this user if they're no longer active</p>
                    </div>
                    <button
                        class="bg-red-500 text-white px-4 py-1 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                        :data-tooltip-content="currentMember?.isOwner ? 'You cannot remove the team owner' : ''"
                        @click="currentMember?.isOwner ? null : removeMember"
                        :disabled="currentMember?.isOwner">Remove</button>
                </div>
            </div>
        </template>

        <div x-show="!current" x-cloak>
            <div class="mt-6 grid grid-cols-12 gap-2 mb-2">
                <div class="col-span-12 sm:col-span-4">
                    <x-search-filter x-model.debounce="search" font-size="base" py="2"></x-search-filter>
                </div>

                <div class="col-span-12 sm:col-span-8 px-4 py-1 bg-white flex flex-wrap items-center gap-4 rounded-lg">
                    Sort by <x-select name="filter" :options="['asc' => 'A-Z', 'desc' => 'Z-A']" x-model="sortBy"></x-select>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="table power-grid-table w-full bg-white rounded-md overflow-clip">
                    <thead class="font-sm font-semibold capitalize bg-[#EDEDED] rounded-t-md">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="pl-6 py-2 text-dark whitespace-nowrap" :style="`width: max-content;`">
                                    <div class="flex @if ($column['center'] ?? false) justify-center @endif">
                                        <div class="inline-flex items-center gap-1">
                                            {{ $column['name'] }}
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y-2">
                        <template x-for="member in members" :key="member.id">
                            <tr>
                                <td @click="current = member.id">
                                    <div
                                        class="pl-6 whitespace-nowrap flex items-center gap-2 cursor-pointer hover:underline hover:text-blue py-3">
                                        <img src="/img/default.png" alt="Avatar" clsss="mr-2" />
                                        <span x-text="member.name"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="pl-6 whitespace-nowrap">
                                        <template x-if="member.isOwner">
                                            <span
                                                class="text-black bg-[#E2E2E2] border-[1px] border-[#D4DDD7] p-2 rounded-full">
                                                Admin
                                            </span>
                                        </template>
                                        <template x-if="!member.isOwner">
                                            @if (count($roles))
                                                <x-select x-init="options = {{ \Illuminate\Support\Js::from($roles) }};" x-model="member.role_id"
                                                    @selected="$wire.updateRole(member.id, $event.detail.selected)"></x-select>
                                            @else
                                                -
                                            @endif
                                        </template>
                                    </div>
                                </td>
                                <td class="pl-6 whitespace-nowrap text-gray-medium2" x-text="member.last_activity_at">
                                </td>
                                <td>
                                    <div class="pl-6 whitespace-nowrap flex justify-between items-center"
                                        x-text="member.start_date">
                                        <div class="mr-3">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

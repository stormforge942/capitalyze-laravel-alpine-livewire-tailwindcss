<div class="w-100" x-data="{
    roles: @entangle('roles').defer,
    permissions: @js($permissions),
    isSetName: false,
    isAdded: false,
    current: @entangle('current').defer,
    roleName: '',
    permissionStatus: [],

    init() {
        this.handleCurrentChange(this.current);
        
        this.$watch('current', (value, _) => {
            window.updateQueryParam('current', value);
            this.handleCurrentChange(value);
        });
    },

    handleCurrentChange(value) {
        if (value && value != 'new') {
            if (this.roles.find(role => role.id == value)) {
                this.isSetName = true;
            } else {
                this.current = '';
                this.isSetName = false;
            }
        } else {
            this.isSetName = false;
        }

        this.$nextTick(() => {
            this.updateCurrentPermissionStatus();
        });
    },

    addRole() {
        if (!this.current) {
            this.current = 'new';
            this.isSetName = false;
        } else {
            if (this.isSetName) {
                const permissionIds = this.permissionStatus
                    .filter(permission => permission.status === true)
                    .map(permission => permission.id);

                if (this.current && this.current != 'new') {
                    this.$wire.updateRole(this.current, this.roleName, permissionIds);
                } else {
                    this.$wire.addRole(this.roleName, permissionIds);
                }

                this.isAdded = true;
            }
        }
    },

    setName() {
        if (this.roleName !== '') this.isSetName = true;
    },

    goBack() {
        this.isSetName = false;
        this.isAdded = false;
        this.roleName = '';
        this.current = '';
    },

    updateCurrentPermissionStatus() {
        const currentRole = this.roles.find(role => role.id == this.current);

        this.permissionStatus = this.permissions.map(permission => {
            let status = false;

            if (currentRole && this.current && this.current != 'new') {
                const bExist = currentRole.permissions.find(item => item.id === permission.id);
                if (bExist) status = true;
            }

            return {
                id: permission.id,
                name: permission.name,
                status: status
            };
        });

        this.roleName = currentRole ? currentRole.name : '';
    },

    setPermissionStatus(id) {
        const item = this.permissionStatus.find(permission => permission.id === id);
        item.status = !item.status;
    }
}">
    <div class="flex items-center justify-between">
        <span x-show="!current" class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Roles</span>
        <button x-show="current" class="flex" @click="goBack()"><img class="mr-2" src="{{ asset('svg/left.svg') }}" alt="Left Icon" /><span class="underline font-bold">Go Back</span></button>
        <button
            x-show="!current || !isAdded"
            class="bg-[#52D3A2] text-black px-4 py-2 rounded font-bold flex items-center mr-3"
            @click="addRole()">
            <span x-text="current && current != 'new' ? 'Modify Role' : 'Add Role'"></span>
            <img x-show="!current || current == 'new'" src="{{ asset('svg/plus_circle.svg') }}" class="ml-2 w-[18px] h-[18px]" />
        </button>
    </div>

    <div class="mt-3 px-3">
        <template x-if="!current">
            <div>
                <template x-for="role in roles" :key="role.id">
                    <div class="flex items-center justify-between py-3 border-b mb-4">
                        <div>
                            <h6 class="text-md font-semibold mb-1" x-text="role.name + ' Level Access'"></h6>
                            <p class="text-sm text-gray-500" x-text="role.permissions.length + ' Functions'"></p>
                        </div>
                        <button class="bg-green-100 text-green-700 px-4 py-1 rounded font-bold" @click="current = role.id;">Modify</button>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="current">
            <div>
                <div x-show="!isSetName">
                    <h2 class="my-6 font-bold text-lg">Enter name of role</h2>

                    <form @submit.prevent="setName" class="flex my-6">
                        <input 
                            class="border px-4 mr-2"
                            name="rolename"
                            x-model="roleName"
                            placeholder="Enter name of the role"
                        />
                        <button type="submit" class="bg-green-light px-4 py-2 rounded">Create Name</button>
                    </form>
                </div>

                <div x-show="isSetName">
                    <div class="flex mb-5 my-6">
                        <span class="text-xl mr-2 font-bold" x-text="roleName"></span>
                        <button @click="isSetName = false;" class="bg-green-light rounded-full flex mr-2 items-center justify-center px-2 text-black">
                            <span class="mr-2 text-sm">EDIT</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.27614 10.595L11.0375 3.83354L10.0947 2.89072L3.33333 9.65217V10.595H4.27614ZM4.82843 11.9283H2V9.09984L9.62333 1.47651C9.88373 1.21616 10.3058 1.21616 10.5661 1.47651L12.4518 3.36213C12.7121 3.62248 12.7121 4.04459 12.4518 4.30494L4.82843 11.9283ZM2 13.2616H14V14.595H2V13.2616Z"
                                    fill="#000000" />
                            </svg>
                        </button>
                    </div>
                    <span>Choose what you want this role to access </span>
                </div>

                <div class="flex flex-wrap justify-stretch flex-row gap-4 mt-6" wire:ignore x-cloak>
                    <template x-for="permission in permissionStatus" :key="permission.id">
                        <button class="rounded-full px-3 py-1 flex items-center justify-center" @click="setPermissionStatus(permission.id)" :class="permission.status ? 'bg-green-light' : 'bg-gray-100'">
                            <span x-text="permission.name" class="mr-2"></span>
                            <img x-show="!permission.status" src="{{ asset('svg/plus.svg') }}" class="w-4 h-4" />
                            <img x-show="permission.status" src="{{ asset('svg/tick.png') }}" class="w-4 h-4" />
                        </button>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>

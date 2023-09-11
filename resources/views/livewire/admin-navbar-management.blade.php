<div class="py-12">
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-11/12 md:mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Users Permissions</h1>
                </div>
            </div>
            <div class="w-full table-fixed border-collapse">
                <table class="table-auto w-full overflow-scroll">
                    <thead>
                        <tr class="block">
                            <th class="font-semibold py-4 text-left py-[10px] px-[5px] w-[200px]">Route</th>
                            <th class="pr-5 py-[10px] px-[5px] w-[200px] text-left">Is Moddable</th>
                            @foreach ($groups as $group)
                            <th class="font-semibold pr-5 py-[10px] px-[5px] w-[200px] text-left">Show For {{ $group->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="block w-full overflow-auto h-[400px]">
                        @foreach ($navbarItems as $navbar)
                        <tr>
                            <td class="font-semibold py-[10px] px-[5px] w-[200px]">
                                <!-- <div class="text-gray-500 text-sm">{{ $navbar->route_name }}</div> -->
                                <div>{{ $navbar->name }}</div>
                                <button wire:click="openEditModal({{ $navbar->id }})">Edit</button>
                            </td>
                            <td class="font-semibold py-[10px] px-[5px] w-[200px]">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer" wire:change="updateNavbarModdable({{ $navbar->id }}, $event.target.value)" @if($navbar->is_moddable) checked @endif type="checkbox" value="{{ $navbar->is_moddable == true ? 0 : 1 }}">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            @if ($navbar->is_moddable)
                                @foreach ($groups as $group)
                                <td class="font-semibold py-[10px] px-[5px] w-[200px]">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input class="sr-only peer" wire:change="updateNavbarShow({{ $navbar->id }}, {{ $group->id }}, $event.target.value)" @if($this->isShow($navbar->id, $group->id)) checked @endif type="checkbox" value="{{ $this->isShow($navbar->id, $group->id) == true ? 0 : 1 }}">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                </td>
                                @endforeach
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div wire:ignore>
    <livewire:edit-navbar-item-modal />
</div>


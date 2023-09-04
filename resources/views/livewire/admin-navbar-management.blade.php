<div class="py-12">
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-2/3 md:mx-auto">
            <div class="sm:flex sm:items-start flex-col">
                <div class="block">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Navbar Management</h1>
                </div>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <table class="table-auto w-full overflow-scroll" wire:loading.remove>
                    <thead>
                        <tr>
                            <td class="font-semibold py-4">Route</td>
                            <td class="pr-5">Is Moddable</td>
                            @foreach ($groups as $group)
                            <td class="font-semibold pr-5">Show For {{ $group->name }}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navbarItems as $navbar)
                        <tr>
                            <td class="font-semibold">
                                <div class="text-gray-500 text-sm">{{ $navbar->route_name }}</div>
                                <div>{{ $navbar->name }}</div>
                            </td>
                            <td class="font-semibold">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer" wire:change="updateNavbarModdable({{ $navbar->id }}, $event.target.value)" @if($navbar->is_moddable) checked @endif type="checkbox" value="{{ $navbar->is_moddable == true ? 0 : 1 }}">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            @if ($navbar->is_moddable)
                                @foreach ($groups as $group)
                                <td class="font-semibold">
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

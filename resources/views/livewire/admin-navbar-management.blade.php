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
                            <td class="pr-5">Is Closed</td>
                            <td class="font-semibold pr-5">Position</td>
                            <td class="pr-5">Is Custom</td>
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
                                <div class="flex items-center mr-4">
                                    <input wire:change="updateNavbarClosed({{ $navbar->id }}, $event.target.value)" @if($navbar->is_closed) checked @endif type="checkbox" value="{{ $navbar->is_closed == true ? 0 : 1 }}" class="w-4 h-4 bg-red-700 text-green-700 ">
                                </div>
                            </td>
                            @if (!$navbar->is_closed)
                                <td class="font-semibold"><input class="w-12" wire:change="updateNavbarPosition({{ $navbar->id }}, $event.target.value)" value="{{ $navbar->position }}"></td>
                                <td class="font-semibold">
                                    <div class="flex items-center mr-4">
                                        <input wire:change="updateNavbarCustom({{ $navbar->id }}, $event.target.value)" @if($navbar->is_custom) checked @endif type="checkbox" value="{{ $navbar->is_custom == true ? 0 : 1 }}" class="w-4 h-4 bg-red-700 text-green-700 ">
                                    </div>
                                </td>
                                @foreach ($groups as $group)
                                <td class="font-semibold">
                                    <div class="flex items-center mr-4">
                                        <input wire:change="updateNavbar({{ $navbar->id }}, {{ $group->id }}, $event.target.value)" @if($this->isShow($navbar->id, $group->id)) checked @endif type="checkbox" value="{{ $this->isShow($navbar->id, $group->id) == true ? 0 : 1 }}" class="w-4 h-4 bg-red-700 text-green-700 ">
                                    </div>
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

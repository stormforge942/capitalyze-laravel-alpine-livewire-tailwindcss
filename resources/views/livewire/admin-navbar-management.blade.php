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
                            <td class="font-semibold py-4">Item</td>
                            @foreach ($groups as $group)
                            <td class="font-semibold py-4">Show For {{ $group->name }}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navbarItems as $navbar)
                        <tr>
                            <td class="font-semibold py-4">{{ $navbar->name }}</td>
                            @foreach ($groups as $group)
                            <td class="font-semibold py-4">
                                <div class="flex items-center mr-4">
                                    <input wire:change="updateNavbar({{ $navbar->id }}, {{ $group->id }}, $event.target.value)" @if($this->isShow($navbar->id, $group->id)) checked @endif value="{{ $this->isShow($navbar->id, $group->id) ? 1 : 0 }}" type="checkbox" class="w-4 h-4 bg-red-700 text-green-700 ">
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

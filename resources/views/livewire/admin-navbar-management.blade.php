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
                            <td class="font-semibold py-4">Show</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navbarItems as $navbar)
                        <tr>
                            <td class="font-semibold py-4">{{ $navbar->name }}</td>
                            <td class="font-semibold py-4">
                                <select wire:change="updateNavbar('{{ $navbar->name }}', $event.target.value === 'true')">
                                    <option value="true" @if ($navbar->show) selected @endif>True</option>
                                    <option value="false" @unless ($navbar->show) selected @endif>False</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

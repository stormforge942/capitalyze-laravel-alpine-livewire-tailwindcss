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
                            <td class="font-semibold py-4">Show For Users</td>
                            <td class="font-semibold py-4">Show For Admins</td>
                            <td class="font-semibold py-4">Show For Developers</td>
                            <td class="font-semibold py-4">Show For Testers</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navbarItems as $navbar)
                        <tr>
                            <td class="font-semibold py-4">{{ $navbar->name }}</td>
                            <td class="font-semibold py-4">
                                <select wire:change="updateNavbarForUsers('{{ $navbar->id }}', $event.target.value)">
                                    <option value="true" @if ($navbar->show_users) selected @endif>True</option>
                                    <option value="false" @unless ($navbar->show_users) selected @endif>False</option>
                                </select>
                            </td>
                            <td class="font-semibold py-4">
                                <select wire:change="updateNavbarForAdmins('{{ $navbar->id }}', $event.target.value)">
                                    <option value="true" @if ($navbar->show_admins) selected @endif>True</option>
                                    <option value="false" @unless ($navbar->show_admins) selected @endif>False</option>
                                </select>
                            </td>
                            <td class="font-semibold py-4">
                                <select wire:change="updateNavbarForDevelopers('{{ $navbar->id }}', $event.target.value)">
                                    <option value="true" @if ($navbar->show_developers) selected @endif>True</option>
                                    <option value="false" @unless ($navbar->show_developers) selected @endif>False</option>
                                </select>
                            </td>
                            <td class="font-semibold py-4">
                                <select wire:change="updateNavbarForTesters('{{ $navbar->id }}', $event.target.value)">
                                    <option value="true" @if ($navbar->show_testers) selected @endif>True</option>
                                    <option value="false" @unless ($navbar->show_testers) selected @endif>False</option>
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

<div class="py-6">
    <div class="mx-auto flex">
        <div class="mt-4 px-4 sm:px-6 lg:px-8 bg-white py-4 shadow rounded w-full md:w-2/3 md:mx-auto">
            @if (session()->has('message'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('message') }}
                </div>
            @endif
            <div class="mb-4 flex justify-between items-center">
                <div>Cache Management</div>
                <button wire:click="clearAllCache" class="mr-12 mt-5 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                    Clear All Cache
                </button>
            </div>
            <div class="mt-8 flow-root rounded-lg overflow-x-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="font-semibold py-4">Cache Name</th>
                            <th class="font-semibold py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $index => $result)
                        <tr>
                            <td class="py-4">
                                {{ ucwords(trim(str_replace('_', ' ', trim(trim($result['assignmentPrefix'], '_'), "'")), " \t\n\r\0\x0B")) }}
                            </td>
                            <td>
                                <button wire:click="clearCacheByPrefix('{{ e($result['assignmentPrefix']) }}')" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                                    Clear
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

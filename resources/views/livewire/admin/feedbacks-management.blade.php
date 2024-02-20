<div class="py-6">
    <div class="max-w-5xl mx-auto">
        <div class="flow-root rounded-lg overflow-x-auto">
            <table class="table-auto min-w-full border-collapse text-left" clas x-data>
                <thead>
                    <tr>
                        <th class="capitalize pl-6 p-2 whitespace-nowrap bg-gray-200">User</th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-200">Area</th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-200">Feedback Types</th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-200">Experience</th>
                        <th class="capitalize p-2 whitespace-nowrap bg-gray-200">Feedback</th>
                        <th colspan="2" class="capitalize p-2 whitespace-nowrap bg-gray-200">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm bg-white">
                    @foreach ($feedbacks as $index => $feedback)
                        <tr class="{{ $index % 2 ? 'bg-gray-200' : '' }}"> <!-- Alternating row colors -->
                            <td class="pl-6 p-2">
                                <p>{{ $feedback->user->name }}</p>
                                <p class="text-gray-600">{{ $feedback->user->email }}</p>
                            </td>
                            <td class="p-2">
                                @foreach ($feedback->areas as $area)
                                    {{ $area }},<br>
                                @endforeach
                            </td>
                            <td class="p-2">
                                @foreach ($feedback->feedback_types as $type)
                                    {{ $type }},<br>
                                @endforeach
                            </td>
                            <td class="p-2">
                                {{ ucfirst($feedback->experience) }}
                            </td>
                            <td class="p-2">
                                <p class="max-w-[150px]">
                                    {{ $feedback->feedback }}
                                </p>
                            </td>
                            <td class="p-2">
                                <button
                                    @click="confirm('Are you sure ?') ? $wire.deleteFeedback({{ $feedback->id }}) : null"
                                    class="bg-red-500 text-white p-2 rounded hover:bg-red-600 flex items-center gap-2 whitespace-nowrap">
                                    <svg class="inline w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>

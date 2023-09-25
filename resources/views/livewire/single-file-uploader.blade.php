<div @dragover.prevent @drop.prevent class="col-span-full" id="dragDiv{{$name}}">
    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
        <div class="text-center">
            <div class="mt-4 text-sm leading-6 text-blue-700 flex justify-center">
                <label
                    for="fileUploadInput{{$name}}"
                    class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-700 focus-within:ring-offset-2 hover:text-blue-600"
                >
                    <span>{{ $fileName ?  : 'Upload a file'}}</span>
                    <input wire:model="file" id="fileUploadInput{{$name}}" name="fileUploadInput{{$name}}" type="file" class="sr-only"/>
                </label>
            </div>
            <p class="text-xs leading-5 text-gray-600">PNG, JPG up to 2MB</p>
        </div>
    </div>
    <script>
        let dragDiv = document.querySelector('#dragDiv' + '{{$name}}')
        let input = document.querySelector('#fileUploadInput' + '{{$name}}')
        const eventName = 'fileUploaded' + '{{$name}}'

        input.addEventListener(
            'change',
            e => {
                console.log(23)
                if (e.target?.files?.length > 0) {
                    let data = new FormData()
                    data.append('file', e.target.files[0])
                    window.livewire.emit(eventName, data)
                }
            }
        )

        dragDiv.addEventListener(
            'drop',
            e => {
                if (e.dataTransfer?.files?.length > 0) {
                    let reader = new FileReader()
                    reader.onloadend = () => {
                        window.livewire.emit(eventName, reader.result)
                    }
                    reader.readAsDataURL(e.dataTransfer.files[0])
                }
            }
        )
    </script>
</div>
{{--@push('scripts')--}}

{{--@endpush--}}

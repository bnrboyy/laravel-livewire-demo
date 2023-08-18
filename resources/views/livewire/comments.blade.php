<div class="flex flex-col gap-2 items-center w-[800px] h-full min-h-screen p-4 overflow-y-hidden ">

    @if ($image)
        <img src={{ $image }} id="preview-img" alt="">
    @endif
    <input type="file" id="image" wire:change="$emit('imageChoosen')" accept="image/jpeg, image/png, image/jpg">
    <div class="flex justify-center items-center gap-2 w-full h-[100px]">
        <div class="flex flex-col justify-center p-0 m-0">
            <textarea class="p-2 border border-gray-500 rounded shadow" name="" id="" cols="90" rows="2"
                wire:model="newComment"></textarea>
            @error('newComment')
                <span class="text-red-500 text-xs text-end">{{ $message }}</span>
            @enderror
        </div>
        <button
            class="w-[100px] h-[67.61px] flex flex-col justify-center items-center rounded bg-blue-500 border shadow"
            wire:click="addComment"><i class="fa-solid fa-plus"></i>Add</button>
    </div>
    <div class="flex flex-col items-center gap-4 w-full h-[calc(100vh-100px)] overflow-auto">
        @foreach ($allComments as $comment)
            <div class="w-full min-h-[100px] h-auto p-4 bg-gray-100 border shadow rounded">
                <div class="flex justify-between">
                    <p class="w-full"><span class="text-lg font-bold">Created at :
                        </span>{{ $comment->created_at->diffForHumans() }}</p>
                    <div class="flex gap-1">
                        <button class="w-[50px] rounded bg-yellow-500 border shadow"
                            wire:click="onDelete({{ $comment->id }})"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <button class="w-[50px] rounded bg-red-500 border shadow"
                            wire:click="onDelete({{ $comment->id }})"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
                <p><span class=" text-lg font-bold">Content : </span>{{ $comment->body }}</p>
                <p><span class=" text-lg font-bold">Creator : </span>{{ $comment->creator->name }}</p>
            </div>
        @endforeach
        {{ $allComments->links('pagination-links') }}
    </div>
    @if (session()->has('message'))
        <script>
            toastr.success("{{ Session::get('message') }}");
            </script>
    @endif
</div>


<script>
    window.addEventListener('deleted', event => { // รับ response (event) จาก livewire component เหมือน axios
        const response = event.detail;
        toastr.success(response.message);
        // ทำตามขั้นตอนต่อไป เช่น ปรับแต่งหน้าเว็บ หรือดำเนินการอื่นๆ
    });
    window.livewire.on('imageChoosen', () => {
        const previewImg = document.querySelector('#preview-img')
        const file = document.getElementById('image')
        const image = file.files[0];

        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result, 1) // โยนฟังก์ชั่นไป livewire component
            // previewImg.src = reader.result;
        }
        reader.readAsDataURL(image);
    })
</script>

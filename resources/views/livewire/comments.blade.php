<div
    class="flex flex-col gap-2 items-center w-[800px] h-full min-h-screen p-4 overflow-y-hidden border-2 border-red-500 ">
    @if (session()->has('messageAdded'))
        <div class="w-full p-3 bg-green-300 text-green-900 rounded">
            {{ session('messageAdded') }}
        </div>
    @endif
    @if (session()->has('messageDel'))
        <div class="w-full p-3 bg-red-300 text-red-900 rounded">
            {{ session('messageDel') }}
        </div>
    @endif
    @if ($image)
        <img src={{ $image }} id="preview-img" alt="">
    @endif
    <input type="file" id="image" wire:change="$emit('imageChoosen')" accept="image/jpeg, image/png, image/jpg">
    <div class="flex justify-center items-center gap-2 w-full h-[100px]">
        <div class="flex flex-col justify-center p-0 m-0">
            <textarea class="p-2 border-2 border-black rounded" name="" id="" cols="70" rows="2"
                wire:model="newComment"></textarea>
            @error('newComment')
                <span class="text-red-500 text-xs text-end">{{ $message }}</span>
            @enderror
        </div>
        <button class="w-[100px] h-[67.61px] rounded bg-red-400" wire:click="addComment">Add</button>
    </div>
    <div class="flex flex-col items-center gap-4 w-full h-[calc(100vh-100px)] overflow-auto">
        @foreach ($allComments as $comment)
            <div class="w-full min-h-[100px] p-4 overflow-auto border border-black">
                <button class="w-[50px] rounded bg-red-500" wire:click="onDelete({{ $comment->id }})"><i class="fa-solid fa-trash"></i></button>
                <p><span class=" text-lg font-bold">Content : </span>{{ $comment->body }}</p>
                <p><span class=" text-lg font-bold">Creator : </span>{{ $comment->creator->name }}</p>
                <p><span class=" text-lg font-bold">Created at : </span>{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
        {{ $allComments->links('pagination-links') }}
    </div>
</div>

<script>
    window.livewire.on('imageChoosen', () => {
        const previewImg = document.querySelector('#preview-img')
        const file = document.getElementById('image')
        const image = file.files[0];

        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result, 1) // โยนฟังก์ชั่นไป livewire component
            // console.log(reader.result)
            // previewImg.src = reader.result;
        }
        reader.readAsDataURL(image);
    })
</script>

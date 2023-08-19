<div class="flex flex-col gap-2 items-center w-[800px] h-full min-h-screen p-4 overflow-y-hidden ">
        <div class="flex flex-wrap gap-2">
            <div class="w-[140px] relative">
                <figure class="group relative h-[145px] shadow-md bg-white rounded-[5px] border border-[#6d71752b]">
                    <div
                        class="group-hover:block absolute inset-0 left-0 top-0 border border-solid border-gray-300 rounded-[5px] pointer-events-none">
                    </div>
                    <button wire:click="removeImg"
                        class="btn-remove {{ $btnRemove }} w-[25px] h-[25px] flex justify-center items-center rounded-[50%] absolute z-50 right-[2px] top-[3px] bg-red-200 bg-opacity-40 duration-500 hover:bg-red-400"><i
                            class="fa-solid fa-xmark"></i></button>
                    <img class="w-full h-full bg-[#e9e9e9] rounded-[4px] object-fill pointer-events-none scale-100 group-hover:scale-90 duration-500"
                        src={{ $image }} id="preview-img" alt="" style="width: 150px;">
                    <input class="cursor-pointer w-full h-full absolute left-0 opacity-0 top-0" type="file"
                        id="image" wire:change="$emit('imageChoosen')" wire:model="file"
                        accept="image/jpeg, image/png, image/jpg">
                </figure>
            </div>
        </div>
        <div class="flex justify-center items-center gap-2 w-full h-[100px]">
            <div class="flex flex-col justify-center p-0 m-0">
                <textarea class="p-2 border border-gray-500 rounded shadow" name="" id="" cols="90" rows="2"
                    wire:model.debounce.500ms="newComment"></textarea>
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
                <div class="w-full min-h-[180px] h-auto p-4 bg-gray-100 border shadow rounded">
                    <div class="flex justify-between">
                        @if ($comment->image)
                            <img src="storage/{{ $comment->image }}" alt="" width=50>
                        @else
                            <img src="{{ $noImg }}" alt="" width=50>
                        @endif
                        <div class="flex items-start gap-1">
                            <button class="w-[50px] rounded bg-yellow-500 border shadow"
                                onclick="my_modal_3.showModal()">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="w-[50px] rounded bg-red-500 border shadow"
                                wire:click="onDelete({{ $comment->id }})"><i
                                    class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                    <div class="flex flex-col w-full">
                        <p class="w-full"><span class="text-lg font-bold">Created at :
                            </span>{{ $comment->created_at->diffForHumans() }}</p>
                        <p><span class=" text-lg font-bold">Content : </span>{{ $comment->body }}</p>
                        <p><span class=" text-lg font-bold">Creator : </span>{{ $comment->creator->name }}</p>
                    </div>
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
{{-- <button class="btn" onclick="my_modal_3.showModal()">open modal</button> --}}
<dialog id="my_modal_3" class="modal">
    <form method="dialog" class="modal-box">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        <h3 class="font-bold text-lg">Hello! Nantachai</h3>
        <p class="py-4">Press ESC key or click on ✕ button to close</p>
    </form>
</dialog>
<script src="{{ asset('js/pages/comment.js') }}"></script>

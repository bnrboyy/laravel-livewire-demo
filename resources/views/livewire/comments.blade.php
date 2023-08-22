<div>
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
                wire:click="addComment"><i class="fa-solid fa-square-plus fa-xl"></i></button>
        </div>
        <div class="flex flex-col items-center gap-4 w-full h-[calc(100vh-100px)] overflow-auto">
            @foreach ($allComments as $comment)
                <div :key="{{ $comment->id }}"
                    class="w-full min-h-[180px] h-auto p-4 bg-gray-100 border shadow rounded">
                    <div class="flex justify-between">
                        @if ($comment->image)
                            <img class="cursor-pointer duration-500 hover:scale-105 rounded border shadow"
                                src="storage/{{ $comment->image }}" alt="" width=50
                                onclick="showImage({{ $comment }})">
                        @else
                            <img src="{{ $noImg }}" alt="" width=50>
                        @endif
                        <div class="flex items-start gap-1">
                            <button class="w-[50px] rounded bg-yellow-500 border shadow"
                                onclick="openDialog({{ $comment }})">
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
        {{-- <button class="btn" onclick="my_modal_3.showModal()">open modal</button> --}}
        <dialog id="my_modal_3" class="modal">
            <div method="dialog" class="modal-box">
                <form>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="w-full flex gap-2 p-2">
                    <div class="flex flex-wrap gap-2">
                        <div class="relative">
                            <figure
                                class="group h-full relative shadow-md bg-white rounded-[5px] border border-[#6d71752b]">
                                <div
                                    class="group-hover:block absolute inset-0 left-0 top-0 border border-solid border-gray-300 rounded-[5px] pointer-events-none">
                                </div>
                                <button onclick="resetImg()"
                                    class="btn-remove2 w-[25px] h-[25px] flex justify-center items-center rounded-[50%] absolute z-50 right-[2px] top-[3px] bg-red-200 bg-opacity-40 duration-500 hover:bg-red-400"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <img src="" alt="" id="imageShow"
                                    class="w-full h-full bg-[#e9e9e9] rounded-[4px] object-fill pointer-events-none scale-100 group-hover:scale-90 duration-500">
                                <input class="cursor-pointer w-full h-full absolute left-0 opacity-0 top-0"
                                    type="file" id="image2" onchange="selectNewImg()"
                                    wire:model.lazy="fileImgUpdate" accept="image/jpeg, image/png, image/jpg">
                            </figure>
                        </div>
                    </div>

                    <div class="w-1/2 flex flex-col">
                        <textarea class="p-2 border-2 border-blue-600 focus:border-2 focus:border-black focus:outline-none rounded"
                            name="" id="editBody" cols="30" rows="10" wire:model="bodyUpdate"></textarea>
                    </div>
                </div>
                <div class="w-full flex justify-center items-center mt-4">
                    <input id="cId" type="hidden">
                    <form action="">
                        <button class="btn btn-sm btn-primary" onclick="onSave()">SAVE</button>
                    </form>
                </div>
            </div>
        </dialog>

        {{-- Show image --}}
        <dialog id="my_modal_2" class="modal">
            <form method="dialog" class="modal-box w-[250px]">
                <img class="rounded" src="" alt="" id="comment-img" width=250>
            </form>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        // });

        function resetImg() {
            const btn_remove = document.querySelector('.btn-remove2');
            const img = document.getElementById('imageShow')
            btn_remove.classList.add('hidden')
            img.src = "images/no-image.png";

        }

        function selectNewImg() {
            const btn_remove = document.querySelector(".btn-remove2");
            const img = document.getElementById('imageShow')
            // btn_remove.classList.add("hidden");
            const file2 = document.getElementById("image2");
            const image2 = file2.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                // window.livewire.emit("fileUpload", reader.result,
                //     1); // โยนฟังก์ชั่นไป livewire component
                img.src = reader.result;
            };
            reader.readAsDataURL(image2);
            btn_remove.classList.remove("hidden");
        }

        function openDialog(_comment) {
            const baseURL = window.location.origin;
            const body = document.getElementById("editBody")
            const iamgeShow = document.getElementById("imageShow")
            const c_id = document.getElementById('cId')

            body.value = _comment.body;
            iamgeShow.src = baseURL + "/" + "storage/" + _comment.image;
            c_id.value = _comment.id;
            my_modal_3.showModal();
        }

        function showImage(_comment) {
            const baseURL = window.location.origin + "/" + "storage" + "/"
            const img = document.getElementById('comment-img')
            img.src = baseURL + _comment.image;
            my_modal_2.showModal();
        }

        function onSave() {
            const body = document.getElementById("editBody")
            if (body.value === "" || !body.value) {
                body.classList.remove("border-blue-600", "focus:border-black")
                body.classList.add("border-red-600")
                body.focus();
                return false;
            } else {
                body.classList.remove('border-red-600')
                body.classList.add("border-blue-600", "focus:border-black")
            }

            const formData = new FormData();
            formData.append('name', 'Natachai')
            formData.append('email', 'nantachai@gmail.com')
            axios.post('/commentupdate', formData).then((res) => {
                console.log(res)
            })

            const c_id = document.getElementById('cId');
            window.livewire.emit("updateComment", c_id.value);

        }

        document.addEventListener('livewire:load', function() {
            // var commenets = @js($allComments);
            // console.log(commenets.data)
            function deleteComment(_id) {
                window.livewire.emit("deleteComment", _id);
            }
            window.addEventListener("deleted", (event) => {
                // รับ response (event) จาก livewire component เหมือน axios
                const response = event.detail;
                toastr.success(response.message);
                // ทำตามขั้นตอนต่อไป เช่น ปรับแต่งหน้าเว็บ หรือดำเนินการอื่นๆ
            });

            window.livewire.on("imageChoosen", () => {
                let btn_remove = document.querySelector(".btn-remove");
                // btn_remove.classList.add("hidden");
                const file = document.getElementById("image");
                const image = file.files[0];
                let reader = new FileReader();
                reader.onloadend = () => {
                    window.livewire.emit("fileUpload", reader.result,
                        1); // โยนฟังก์ชั่นไป livewire component
                    // previewImg.src = reader.result;
                };
                reader.readAsDataURL(image);
                btn_remove.classList.remove("hidden");
            });
        })
    </script>
</div>
{{-- <script src="{{ asset('js/pages/comment.js') }}"></script> --}}

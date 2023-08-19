const file = document.getElementById("image");
let btn_remove = document.querySelector(".btn-remove");
const previewImg = document.querySelector("#preview-img");
btn_remove.classList.add("hidden");

window.addEventListener("deleted", (event) => {
    // รับ response (event) จาก livewire component เหมือน axios
    const response = event.detail;
    toastr.success(response.message);
    // ทำตามขั้นตอนต่อไป เช่น ปรับแต่งหน้าเว็บ หรือดำเนินการอื่นๆ
});

window.livewire.on("imageChoosen", () => {
    const image = file.files[0];
    let reader = new FileReader();
    reader.onloadend = () => {
        window.livewire.emit("fileUpload", reader.result, 1); // โยนฟังก์ชั่นไป livewire component
        // previewImg.src = reader.result;
    };
    reader.readAsDataURL(image);
    btn_remove.classList.remove("hidden");
});

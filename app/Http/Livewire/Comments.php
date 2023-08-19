<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;
    // public $allComments;
    public $newComment;
    public $noImg = "https://backoffice.juppgas-delivery.shop/images/no-image.png";
    public $image;
    public $file;
    public $btnRemove = "";

    public function __construct()
    {
        $this->image = $this->noImg;
    }

    protected $listeners = ['fileUpload' => 'handlePreviewImg'];

    public function handlePreviewImg($imageSrc, $id)
    {
        $this->image = $imageSrc;
    }
    // public function mount()
    // { // ฟังก์ชั่นที่จะทำงานเมื่อ Render commponent.
    //     $initialComments = Comment::latest()->get(); // Order by DESC
    //     $this->allComments = $initialComments;
    // }

    public function updated($field)
    { // Realtime Validation.
        $this->validateOnly($field, ['newComment' => 'required|max:255']);
    }

    public function addComment()
    {
        $this->validate(['newComment' => 'required|max:255']);
        if ($this->newComment === "") {
            return false;
        }

        $imageSrc = "";
        if ($this->file) {
            $imageSrc = $this->storeImage();
        }
        $createdComment = Comment::create([
            'body' => $this->newComment,
            'user_id' => 1,
            'image' => $imageSrc,
        ]);
        if ($createdComment) {
            $this->newComment = "";
            // $this->allComments->prepend($createdComment);
            $this->image = $this->noImg;
            $this->btnRemove = "hidden";
            session()->flash('message', 'Created successfully.');
            $this->file = null;

        }
        // array_unshift($this->allComments, [ // เพื่ม array ไปตำแหน่งแรก
        //     'body' => $this->newComment,
        //     'created_at' => Carbon::now()->diffForHumans(),
        //     'creator' => 'Ruecha'
        // ]);
    }

    public function storeImage()
    {
        if (!$this->image) return null;

        $path = 'uploads' . "/" . date('Y') . "/" . date('m');
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        $filePath = $this->file->store($path, 'public');
        return $filePath;

        // $imgName = Str::random() . time() . '.jpg';
        // $img = ImageManagerStatic::make($this->image)->encode('jpg');
        // Storage::disk('public')->put($imgName, $img);
        // return $imgName;
    }

    public function onDelete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => "Deleted!", 'status' => 200]);
        // session()->flash('message', 'Comment has been deleted successfully.');
        // $this->mount(); // เรียกใข้งาน function mount()
    }



    public function render()
    {
        return view('livewire.comments', [
            'allComments' => Comment::latest()->paginate(5)
        ]);
    }
}

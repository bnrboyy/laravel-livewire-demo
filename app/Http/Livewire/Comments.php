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
    public $noImg = "images/no-image.png";
    public $image;
    public $file;
    public $btnRemove = "hidden";

    public $formEdit = [
        'comment' => "",
        'image' => "",
    ];

    public function __construct()
    {
        $this->image = $this->noImg;
    }

    protected $listeners = ['fileUpload' => 'handlePreviewImg', 'deleteComment', 'getCommentOne'];

    public function handlePreviewImg($imageSrc, $id)
    {
        $this->image = $imageSrc;
        $this->btnRemove = "";
    }

    public function deleteComment($id)
    {
        dd($id);
    }

    public function removeImg()
    {
        $this->image = $this->noImg;
        $this->file = null;
        $this->btnRemove = "hidden";
    }
    public function mount()
    { // ฟังก์ชั่นที่จะทำงานเมื่อ Render commponent.
        // $this->redirect(route('comment'));
        // $initialComments = Comment::latest()->get(); // Order by DESC
        // $this->allComments = $initialComments;
    }

    public function updated($field) // Realtime Validation.
    {
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
            // $this->allComments->prepend($createdComment); // push ข้อมูลไปตำแหน่งแรกของ อาเรย์
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

    public function getCommentOne($id)
    {
        $comment = Comment::where(['id' => $id])->first();
        if ($comment) {
            $this->formEdit['comment'] = $comment->body;
            $this->formEdit['image'] = $comment->image;
            $this->dispatchBrowserEvent('getCommentOne', ['message' => "get comment success", 'status' => 200, 'data' => $comment]);
        }


    }

    public function onDelete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => "Deleted!", 'status' => 200]);
        // $this->image = $this->noImg;
        // $this->file = null;
        // $this->newComment = "";
        // session()->flash('message', 'Comment has been deleted successfully.');
        // $this->mount(); // เรียกใข้งาน function mount()
    }



    public function render()
    {
        // return view('livewire.comments', [
        //     'allComments' => Comment::latest()->paginate(3)
        // ]);
        return view('livewire.comments', [
            'allComments' => Comment::latest()->paginate(3)
        ]);
    }
}

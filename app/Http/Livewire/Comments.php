<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    // public $allComments;
    public $newComment;
    public $image;

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

        $createdComment = Comment::create(['body' => $this->newComment, 'user_id' => 1]);
        // $this->allComments->prepend($createdComment);
        $this->newComment = "";
        session()->flash('message', 'Created successfully.');
        // array_unshift($this->allComments, [ // เพื่ม array ไปตำแหน่งแรก
        //     'body' => $this->newComment,
        //     'created_at' => Carbon::now()->diffForHumans(),
        //     'creator' => 'Ruecha'
        // ]);
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

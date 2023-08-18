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

    public function handlePreviewImg($imageSrc, $id) {
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
        session()->flash('messageAdded', 'Comment has been created successfully.');
        // array_unshift($this->allComments, [ // เพื่ม array ไปตำแหน่งแรก
        //     'body' => $this->newComment,
        //     'created_at' => Carbon::now()->diffForHumans(),
        //     'creator' => 'Ruecha'
        // ]);
    }

    public function onDelete($id)
    {
        Comment::find($id)->delete();
        // $this->mount(); // เรียกใข้งาน function mount()
        session()->flash('messageDel', 'Comment has been deleted successfully.');
    }

    public function render()
    {
        return view('livewire.comments', [
            'allComments' => Comment::latest()->paginate(5)
        ]);
    }
}

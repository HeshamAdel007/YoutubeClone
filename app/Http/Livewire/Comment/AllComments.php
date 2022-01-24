<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Video;

class AllComments extends Component
{

    public $video;

    protected $listeners = ['commentCreated' => '$refresh'];

    public function mount(Video $video)
    {
        $this->video = $video;
    } // End Of mount

    public function render()
    {
        return view('livewire.comment.all-comments');
    } // End Of render

} // End Of Controller

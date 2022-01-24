<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Video;

class NewComment extends Component
{

    public $video;
    public $body;
    public $replayId;


    public function mount(Video $video, $replayId)
    {
        $this->video = $video;
        $replayId == 0 ? $this->replayId = null : $this->replayId = $replayId;
    } // End Of mount


    public function addComment()
    {

        // Validaiton
        auth()->user()->comments()->create([
            'body'      => $this->body,
            'video_id'  => $this->video->id,
            'replay_id' => $this->replayId,
        ]);

        $this->body = "";
        // Emit Events Resfresh
        $this->emit('commentCreated');
    } // End Of addComment


    public function resetForm()
    {
        $this->body = "";
    } // End Of resetForm


    public function render()
    {
        return view('livewire.comment.new-comment')->extends('layouts.app');
    } // End Of render


} // End Of Controller

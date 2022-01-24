<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use App\Models\Channel;
use App\Models\Video;

class EditVideo extends Component
{

    public Channel $channel;
    public Video $video;

    protected $rules = [
        'video.title'        => 'required|max:255',
        'video.description'  => 'nullable',
        'video.visibility'   => 'required|in:private,public,unlisted',
    ]; // End Of Rules

    public function mount($channel, $video) {
        $this->channel = $channel;
        $this->video   = $video;
    } // End Of Mount


    public function update()
    {
        $this->validate();

        // Update Video
        $this->video->update([
            'title'       => $this->video->title,
            'description' => $this->video->description,
            'visibility'  => $this->video->visibility
        ]);

        session()->flash('message', 'video was update ');
    } // End OF update

    public function render()
    {
        return view('livewire.video.edit-video')->extends('layouts.app');
    } // End Of Render

} // End Of Livewire

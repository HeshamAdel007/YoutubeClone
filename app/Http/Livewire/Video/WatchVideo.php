<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use App\Models\Video;

class WatchVideo extends Component
{

    public Video $video;

    protected $listeners = ['VideoViewed' => 'countView'];

    public function mount($video) {
        $this->video = $video;
    } // End Of mount



    public function countView()
    {

        $this->video->update([
            'views' => $this->video->views + 1
        ]);
    } // End Of countView



    public function render()
    {
        return view('livewire.video.watch-video')->extends('layouts.app');
    } //End Of render

} //End Of livewier

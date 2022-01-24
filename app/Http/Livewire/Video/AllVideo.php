<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use App\Models\Video;
use App\Models\Channel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class AllVideo extends Component
{

    use WithPagination, AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    public $channel;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;

    } // End Of Mount

    public function delete(Video $video)
    {
        // Check If User Allowed Deleted Video
        $this->authorize('delete', $video);

        // Delete  Video Folder
        $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

        if ($deleted) {
            $video->delete();
        }

        return back();
    } // End Of Delete

    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', $this->channel->videos()->paginate(5))
            ->extends('layouts.app');
    } // End Of Render

} // End Of Livewire

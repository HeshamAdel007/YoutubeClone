<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Channel;
use App\Models\Video;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;

class CreateVideo extends Component
{

    use WithFileUploads;

    public Channel $channel;
    public Video $video;
    public $videoFile;

    protected $rules = [
        'videoFile' => 'required|mimes:mp4|max:1228800'
    ]; // End Of Rules


    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    } // End Of Mount


    public function fileCompleted()
    {
        $this->validate();

        // Save File
        $path = $this->videoFile->store('videos-temp');

        // Create Video
        $this->video = $this->channel->videos()->create([
            'title'        => 'untitled',
            'description'  => 'none',
            'uid'          => uniqid(true),
            'visibility'   => 'private',
            'path'         => explode('/', $path)[1]
        ]);

        // Disptach Jobs
        CreateThumbnailFromVideo::dispatch($this->video);
        ConvertVideoForStreaming::dispatch($this->video);

        // Redirect To Edit Page
        return redirect()->route('video.edit', [
            'channel' => $this->channel,
            'video'   => $this->video,
        ]);

    } // End Of fileCompleted


    public function render()
    {
        return view('livewire.video.create-video')->extends('layouts.app');
    } // End Of Render

} // End Of Livewire

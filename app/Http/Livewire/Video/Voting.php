<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use App\Models\Dislike;
use App\Models\Like;
use App\Models\Video;

class Voting extends Component
{
    public $video;
    public $likes;
    public $dislikes;
    public $likeActive;
    public $dislikeActive;

    protected $listeners = ['load_values' => '$refresh'];

    public function mount(Video $video)
    {
        $this->video = $video;
        $this->checkIfLiked();
        $this->checkIfDisiked();
    } // End Of Mount

    // Check This User Liked Video Or No && Change Activ
    public function checkIfLiked()
    {
        $this->video->doesUserLikedVideo() ?  $this->likeActive = true : $this->likeActive = false;
    } // End Of Check Like

    // Check This User Disliked Video Or No && Change Activ
    public function checkIfDisiked()
    {
        $this->video->doesUserDislikeVideo() ?  $this->dislikeActive = true : $this->dislikeActive = false;
    } // End Of Check Dislike


    public function like()
    {
        // Check User Alredy Like Video
        if ($this->video->doesUserLikedVideo()) {

            // Delete like in Like Table where VideoId == $this->video just this like
            Like::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();

            // Change likeActive To False
            $this->likeActive = false;

        } else {

            // User Like Video
            $this->video->likes()->create([
                'user_id' => auth()->id()
            ]);

            // After User Make Like -> Disable Dislike
            $this->disableDislike();

            // Change likeActive To True
            $this->likeActive = true;
        }

        // Emit Events Resfresh To Load Like Value
        $this->emit('load_values');
    } // End Of Like


    public function dislike()
    {
        // Check User Alredy Dislike Video
        if ($this->video->doesUserDislikeVideo()) {
            Dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();

            // Change likeActive To False
            $this->dislikeActive = false;
        } else {

            // User Dislike Video
            $this->video->dislikes()->create([
                'user_id' => auth()->id()
            ]);

            // After User Make Dislike -> Disable Like
            $this->disableLike();

            // Change likeActive To True
            $this->dislikeActive = true;
        }

        // Emit Events Resfresh To Load Dislike Value
        $this->emit('load_values');
    } // End Of dislike


    // Remove this user From Like && Return Active False
    public function disableLike()
    {
        Like::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
        $this->likeActive = false;
    } // End Of disableLike

    // Remove this user From Dislike && Return Active False
    public function disableDislike()
    {
        Dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
        $this->dislikeActive = false;
    } // End Of disableDislike


    public function render()
    {   // Count  Video Like
        $this->likes = $this->video->likes->count();
        // Count  Video Dislike
        $this->dislikes = $this->video->dislikes->count();

        return view('livewire.video.voting')
            ->extends('layouts.app');
    } // End Of render


} // End Of Controller

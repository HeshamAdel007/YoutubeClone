<?php

namespace App\Http\Livewire\Channel;

use Livewire\Component;
use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class ChannelInfo extends Component
{

    public $channel;
    public $userSubscribed = false;


    public function mount(Channel $channel)
    {
        $this->channel = $channel;

        if (Auth::check()) {
            // Check If User Subscribe
            if (auth()->user()->isSubscribedTo($this->channel)) {
                $this->userSubscribed = true;
            }
        }
    } // End Of mount


    public function toggle()
    {
        // Check User has Login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check If User Is Subscribe
        if (auth()->user()->isSubscribedTo($this->channel)) {
            // Delete Subscribe From This ChannelId == ChannelId
            Subscription::where('user_id', auth()->id())->where('channel_id', $this->channel->id)->delete();

            // Make Subscribed Button False Because This User Is Not SubscribeNow
            $this->userSubscribed = false;

        } else {

            // If This User Not Subscribe add Subscribe
            Subscription::create([
                'user_id' => auth()->id(),
                'channel_id' => $this->channel->id
            ]);
            // Make Subscribed Button True Because This User Is Subscribe Now
            $this->userSubscribed = true;
        }
    } // End Of Toggle

    public function render()
    {
        return view('livewire.channel.channel-info')->extends('layouts.app');
    } // End Of render

} // End Of Controller

<?php

namespace App\Http\Livewire\Channel;

use Livewire\Component;
use App\Models\Channel;
use Livewire\WithFileUploads;
use Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditChannel extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public $channel;
    public $image;


    protected function rules()
    {
        return [

            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'nullable',
            'image' => 'nullable|image|max:1024',

        ];
    } // End Of Rules


    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    } // End Of Mount



    public function update()
    {

        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([

            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,

        ]);

        // Check Image Is Submitted

        if ($this->image) {
            // Save Image

            $image = $this->image->storeAs('images', $this->channel->uid . '.png');
            $imageImage = explode('/', $image)[1];
            // Resize && Convert To Png
            $img = Image::make(storage_path() . '/app/'  . $image)
                ->encode('png')
                ->fit(100, 100, function ($constraint) {
                    $constraint->upsize();
                })->save();

            // Update File In Database

            $this->channel->update([
                'image' => $imageImage
            ]);

        }

        session()->flash('message', 'Channel updated');

        return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);
    } // End Of Update

    public function render()
    {
        return view('livewire.channel.edit-channel');
    } // End Of Render

} // End Of Controller

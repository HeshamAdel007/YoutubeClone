<div class="my-5">
    <div class="d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center">
            <img
                src="{{ asset('/images/' . $channel->image)}}" class="rounded-circle"style="margin-right: 10px;">

            <div class="ml-2" style="padding-top: 1.5em;">

                <h4 style="text-transform: capitalize;font-weight: bold;">
                    {{$channel->name}}
                </h4>

                <p class="gray-text text-sm"style="font-weight: bold;">
                    {{$channel->subscribers()}} subscribers
                </p>
            </div>
        </div>

        <div>
            <button wire:click.prevent="toggle"
                class="btn btn-lg text-uppercase {{$userSubscribed ? 'sub-btn-active' : 'sub-btn'}} " style="padding: 0;font-weight: bold;">
                {{$userSubscribed ? 'Subscribed' : 'Subscribe'}}
            </button>
        </div>
    </div>
</div>

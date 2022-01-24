<!-- Get All Comment -->
@foreach ($comments as $comment)
<div class="media my-3" x-data="{ open: false , openReply:false}">
    <div>
        <!-- Img -->
        <img
            class="mr-3 rounded-circle"
            src="{{ asset('/images/' . $comment->user->channel->image)}}"
            alt="Generic placeholder image" style="display: inline-block;">
        <!-- User Name && Time -->
        <h5
            class="mt-0"
            style="text-transform:capitalize;font-weight:bold;display:inline-block;">
            {{$comment->user->name}}
            <small class="text-muted">
                {{$comment->created_at->diffForHumans()}}
            </small>
        </h5>
    </div>
    <!-- Comment Body -->
    <div class="media-body">
         <p class="commentbody">
            {{$comment->body}}
            <!-- Replays-->
            <span class="mt-3 replaycomment">
                <a href="" class="text-muted" @click.prevent="openReply = !openReply"style="color: red !important;"> Replay</a>
            </span>
        </p>
        <!-- Add Comment -->
        @auth
            <div class="my-2" x-show="openReply" style="width: 50em;margin: 0 2.5em;">
                <livewire:comment.new-comment :video="$video" :replayId="$comment->id" :key="$comment->id . uniqid() " />
            </div>
        @endauth
        <!-- All Comment -->
        @if ($comment->replaying->count())
            <a href="" @click.prevent="open = !open"> view {{ $comment->replaying->count()}} replaying</a>
            <div x-show="open" >
                @include('includes.allcomments', ['comments' => $comment->replaying])
            </div>

        @endif
    </div>
</div>

@endforeach

@push('custom-css')
<style type="text/css">
    .media {
        border: solid 1px #181818;
        background-color: #f3efef;
        padding: 1em;
    }
</style>
@endpush


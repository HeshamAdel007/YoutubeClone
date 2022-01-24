<div>
    @include('includes.allcomments', ['comments' => $video->comments()->latestFirst()->get()])
</div>


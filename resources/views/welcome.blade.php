@extends('layouts.app')

@section('content')

<div class="container">
    {{-- search --}}
    <form action="/search" method="GET">
        <div class="d-flex align-items-center my-3">
            <input type="text" name="query" id="query" class="form-control" placeholder="Search">
            <button type="submit" class="search-btn"><i class="material-icons">search</i></button>
        </div>
    </form>
    {{-- search --}}
    <div class="row my-4">
        @foreach ($channels as $video)
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('video.watch', $video)}}" class="card-link">
                <div class="card mb-4">
                    @include('includes.videoThumbnail')
                    <div class="card-body">
                        <div class="align-items-center">
                            <img src="{{asset('/images/' . $video->channel->image)}}" height="40px"
                                class="rounded circle">

                            <h4 class="ml-3" style="display: inline-block;">{{$video->title}}</h4>

                        </div>
                        <p class="text-gray mt-4 font-weight-bold" style="line-height: 0.2px;padding: 1em 0;">
                            {{ $video->channel->name}}
                        </p>
                        <p class="text-gray font-weight-bold" style="line-height: 0.2px;padding: 1em 0;">{{ $video->views}} views •
                            {{$video->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            </a>

        </div>
        @endforeach
    </div>
    <div class="card-footer clearfix">
        {{ $channels->links() }}
    </div>
</div>
@endsection

@push('custom-css')
<style type="text/css">
    .card {
        padding: 1em;
    }
</style>
@endpush

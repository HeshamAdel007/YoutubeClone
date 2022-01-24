@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid bg-primary">
    <div class="container">
        <h1 class="display-4" style="color: white;text-transform: capitalize;font-weight: bold;">{{$channel->name}}</h1>
        <p class="lead" style="font-weight: bold;">{{$channel->description}}</p>
    </div>
</div>


<div class="container">
    <!-- Channel Info -->
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <!-- Channel Img -->
            <img src="{{ asset('/images/' . $channel->image)}}" class="rounded-circle mr-3" height="130px;" style="margin-right: 10px;">

            <div>

                <!-- Channel Name -->
                <h3 style="text-transform: capitalize;font-weight: bold;">
                    {{$channel->name}}
                </h3>

                <!-- Channel Subscribers -->
                <p style="font-weight: bold;">
                    {{ $channel->subscribers() }} Subscribers
                </p>
            </div>
        </div>
        <!-- Channel Edit Button -->
        <div>
            @can('update', $channel)
                <a
                    href="{{route('channel.edit', $channel)}}"
                    class="btn btn-primary">  Edit Channel</a>
            @endcan
        </div>
    </div>

    <!-- Videos -->
    <div>
        <div class="row my-4">
            <!-- Featch All Videos -->
            @foreach ($channel->videos as $video)

            <div class="col-12 col-md-6 col-lg-4">
                <!-- Video Link -->
                <a href="{{ route('video.watch', $video)}}" class="card-link">
                    <div class="card mb-4">
                        <!-- Videos -->
                        @include('includes.videoThumbnail')

                        <div class="card-body">
                            <div class="align-items-center">
                                <!-- Channel Img -->
                                <img
                                    src="{{asset('/images/' . $video->channel->image)}}" height="40px"class="rounded circle">

                                <!-- Video Title -->
                                <h4 class="ml-3" style="display: inline-block;">
                                    {{$video->title}}
                                </h4>
                            </div>
                            <!-- Channel Name -->
                            <p class="text-gray mt-4 font-weight-bold" style="line-height: 0.2px;padding: 1em 0;">
                                {{ $video->channel->name}}
                            </p>
                            <!-- Video Views && Time -->
                            <p class="text-gray font-weight-bold" style="line-height: 0.2px;padding: 1em 0;">
                                {{ $video->views}} views •
                                {{$video->created_at->diffForHumans()}}
                            </p>
                        </div>
                    </div>
                </a>

            </div>
            @endforeach
        </div>

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

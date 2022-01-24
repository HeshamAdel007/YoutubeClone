<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Video;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    } // End Of construct


    public function formatDuration($seconds)
    {
        $duration = gmdate('H:i:s', $seconds);
        return $duration;
    } // End Of formatDuration

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $destination = '/' . $this->video->uid . '/' . $this->video->uid . '.m3u8';
        $low = (new X264)->setKiloBitrate(500);
        $high = (new X264)->setKiloBitrate(1000);

        $media =  FFMpeg::fromDisk('videos-temp')
            ->open($this->video->path)
            ->exportForHLS()
            ->addFormat($low, function ($filters) {
                $filters->resize(640, 480);
            })
            ->addFormat($high, function ($filters) {
                $filters->resize(1280, 720);
            })
            // Update Processed In Database
            ->onProgress(function ($progress) {
                $this->video->update([
                    'processing_percentage' => $progress
                ]);
            })
            ->toDisk('videos')
            ->save($destination);

        $seconds = $media->getDurationInSeconds();
        $this->video->update([
            'processed'       => true,
            'proccessed_file' => $this->video->uid . '.m3u8',
            'duration'        => $this->formatDuration($seconds)
        ]);

        // Delete Video From videos-temp After Finished Uploade Video
        $result = Storage::disk('videos-temp')->delete($this->video->path);
        Log::info($this->video->path . ' video was deleted from videos-temp folder');

    } // End Of Handle


} // End Of Job

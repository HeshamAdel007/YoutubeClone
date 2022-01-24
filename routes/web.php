<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;
use App\Http\Livewire\Video\AllVideo;
use App\Http\Livewire\Video\CreateVideo;
use App\Http\Livewire\Video\EditVideo;
use App\Http\Livewire\Video\WatchVideo;
use App\Http\Controllers\HomeController;
use App\Models\Channel;
use App\Models\Video;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


//============================ Welcome page ============================
Route::get('/', [HomeController::class, 'welcomePage'])->name('welcome.page');


//============================ Watch Viedo page ============================
Route::get('/watch/{video}', WatchVideo::class)->name('video.watch');


//============================ Channel page ============================
Route::get('/channels/{channel}', [ChannelController::class, 'index'])->name('channel.index');

//============================ Search page ============================
Route::get('/search/', [HomeController::class, 'search'])->name('search');




Route::middleware('auth')->group(function () {

    //============================== Home Page============================
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    //============================== Channel Edit ============================
    Route::get('/channel/{channel}/edit', [ChannelController::class, 'edit'])->name('channel.edit');

    //============================== Channel Create ============================
    Route::get('/videos/{channel}/create', CreateVideo::class)->name('video.create');

    //============================== Video Edit ============================
    Route::get('/videos/{channel}/{video}/edit', EditVideo::class)->name('video.edit');
    //============================== All Videos ============================
    Route::get('/videos/{channel}', AllVideo::class)->name('video.all');

});

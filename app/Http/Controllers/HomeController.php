<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Show All Viedos Channel Maked I Subscribed
        $channels = Auth::user()->subscribedChannels()->with('videos')->get()->pluck('videosHome');
        return view('home', compact('channels'));
    } // End Of Index

    // Show All Public Viedo In Welome Page
    public function welcomePage() {
        $channels = Video::with('channel:id,name,slug,uid,image')->where('visibility', 'public')->simplePaginate('5');
        return view('welcome', compact('channels'));
    }


    public function search(Request $request)
    {

        if ($request->input('query')) {
            $q = $request->input('query');

            $videos = Video::query()
                ->where('title', 'LIKE', "%{$q}%")
                ->orWhere('description', 'LIKE', "%{$q}%")
                ->get();
        } else {
            $videos = [];
        }

        return view('search', compact('videos'));
    } // End Of Search

} // End Of Controller

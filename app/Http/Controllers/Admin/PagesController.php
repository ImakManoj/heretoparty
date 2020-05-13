<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use App\Content;
use App\Page;
use Illuminate\Http\Request;
use wapmorgan\Mp3Info\Mp3Info;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $results = Page::orderBy('id', 'DESC')->get();

        return view('admin.help_pages.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $artists = Content::where(['cat_id'=>'1'])->get();
        $albums = Content::where(['cat_id'=>'2'])->get();
        $playlists = Content::where(['cat_id'=>'3'])->get();
        $tracks = Content::where(['cat_id'=>'4'])->get();

        return view('admin.songs.create', compact('artists', 'albums', 'playlists', 'tracks'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $image = "";
        $song_id = "";
        $duration = "";
        $songFile = "";

        $selectedArtist = $requestData['selectedArtist'];
        $selectedAlbum = $requestData['selectedAlbum'];
        $selectedPlaylist = $requestData['selectedPlaylist'];
        $selectedTrack = $requestData['selectedTrack'];

        if ($selectedArtist) {

            $contents_data[] = $selectedArtist;
        }
        if ($selectedAlbum) {

            $contents_data[] = $selectedAlbum;
        }
        if ($selectedPlaylist) {

            $contents_data[] = $selectedPlaylist;
        }
        if ($selectedTrack) {

            $contents_data[] = implode(',', $selectedTrack);
        }

        if (!empty($contents_data)) {
            $contents_ids = implode(',', $contents_data);
        }
        if($request->file('image')){
            $image = $this->uploadS3Data(@$request->file('image'), 'songPic');
        }

        if($request->file('song')){

            $audio = new Mp3Info($request->file('song'), true);
            $duration = (int) ($audio->duration)*1000; // duration in milliseconds
            $songFile = $this->uploadS3Data(@$request->file('song'), 'songs');

            $data = [
                'content_id' => $contents_ids,
                'image'      => $image,
                'song'       => $songFile,
                'duration'   => $duration,
                'name'       => $requestData['name'],
                'subtitle'   => $requestData['subtitle'],
                'description'=> $requestData['description'],
            ];

            $song = Song::create($data);
            if ($song) {
                $payload = [];
                $payload = [
                    'title' =>'Add new song', 
                    'body'  => 'New song added', 
                    'value' => '', 
                    'type'  => 2
                ];
                
                $this->sendNotification($user = [], $payload);
            }

        }

        return redirect('admin/songs')->with('flash_message', 'Song added!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $song = Song::findOrFail($id);

        return view('admin.songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = Page::findOrFail($id);

        return view('admin.help_pages.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $data = Page::findOrFail($id);

        $data->title = $requestData['title'];
        $data->description = $requestData['description'];
        $data->save();

        return redirect('admin/help_pages')->with('flash_message', 'Page updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Song::destroy($id);

        return redirect('admin/songs')->with('flash_message', 'Song deleted!');
    }

    public static function songPlayCount($id) {
        $get_data = Stats::selectRaw('sum(stats.play_count) as play_count, song_id')->where('song_id', $id)->groupBy('song_id')->orderBy('play_count', 'DESC')->get();
        if (!empty($get_data)) {

            return (int) @$get_data[0]->play_count;
        } else{

            return 0;
        }

    }


}

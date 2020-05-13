<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use App\Content;
use App\Banner;
use App\FeaturedPlaylist;
use Illuminate\Http\Request;
use wapmorgan\Mp3Info\Mp3Info;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class FeaturedPlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $results = FeaturedPlaylist::where(['status'=> 1])->with('getPlaylistInfo')->orderBy('id', 'DESC')->get();
        return view('admin.featured_playlist.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $artists = Content::where(['cat_id'=>'1'])->get();
        // $albums = Content::where(['cat_id'=>'2'])->get();
        // $tracks = Content::where(['cat_id'=>'4'])->get();

        $exists_ids = FeaturedPlaylist::pluck('content_id')->toArray();

        
        $query = Content::where(['cat_id'=>'3']);
        if ($exists_ids) {
            $query->whereNotIn('id', $exists_ids);
        }
        $playlists = $query->get();

        return view('admin.featured_playlist.create', compact('playlists'));
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
        if ($request->input('playlist')) {
            $data = [
                'content_id' => $request->input('playlist'),
            ];

            $store = FeaturedPlaylist::create($data);
        }

        return redirect('admin/featured_playlist')->with('flash_message', 'Playlist added!');
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
        $song = Song::findOrFail($id);

        $artists    = Content::where(['cat_id'=>'1'])->get();
        $albums     = Content::where(['cat_id'=>'2'])->get();
        $playlists  = Content::where(['cat_id'=>'3'])->get();
        $tracks     = Content::where(['cat_id'=>'4'])->get();

        $getArtist      = Song::where(['id' => $id ])->first(['content_id']);
        $getAlbum       = Song::where(['id' => $id ])->first(['content_id']);
        $getPlaylist    = Song::where(['id' => $id ])->first(['content_id']);
        $getTrack       = Song::where(['id' => $id ])->first(['content_id']);



        return view('admin.songs.edit', compact('song', 'artists', 'albums', 'playlists', 'tracks', 'getArtist', 'getAlbum', 'getPlaylist', 'getTrack'));
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

        if (!empty($requestData['selectedArtist'])) {

            $contents_data[] = $requestData['selectedArtist'];
        }
        if (!empty($requestData['selectedAlbum'])) {

            $contents_data[] = $requestData['selectedAlbum'];
        }
        if (!empty($requestData['selectedPlaylist'])) {

            $contents_data[] = $requestData['selectedPlaylist'];
        }
        if (!empty($requestData['selectedTrack'])) {

            $contents_data[] = implode(',', $requestData['selectedTrack']);
        }

        $song = Song::findOrFail($id);
        // if ($song) {
        //     $song_cont_ids = explode(',', $song->content_id);
        //     if (array_diff($song_cont_ids, $contents_data)) {
        //         dd(implode(',', $contents_data));
        //     }else{
        //         dd($song_cont_ids);
        //     }
        // }

        $song->content_id = implode(',', @$contents_data);

        $image = "";
        $song_id = "";
        $songFile = "";
        $duration = "";

        if($request->file('image')){
            $song->image = $this->uploadS3Data(@$request->file('image'), 'songPic');
            // Song::where(['group_id'=>$id])->update(['image'=>$image]);
        }else{
            $song->image = !empty($song['image'])?$song['image']:"";
        }

        if($request->file('song')){
            $song->song = $this->uploadS3Data(@$request->file('song'), 'songs');

            $audio = new Mp3Info($request->file('song'), true);
            $song->duration = (int) ($audio->duration)*1000; // duration in milliseconds

            // Song::where(['group_id'=>$id])->update(['song'=>$songFile, 'duration'=>$duration]);
        }else{
            $song->song = @$song['song'];
            $song->duration = (int) @$song['duration'];
        }

        if (!empty($requestData['name'])) {
            $song->name = $requestData['name'];
        }else{
            $song->name = $song['name'];
        }

        if (!empty($requestData['subtitle'])) {
            $song->subtitle = $requestData['subtitle'];
        }else{
            $song->subtitle = $song['subtitle'];
        }
        if (!empty($requestData['description'])) {
            $song->description = $requestData['description'];
        }else{
            $song->description = $song['description'];
        }


        $song->save();

        return redirect('admin/songs')->with('flash_message', 'Song updated!');
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
        FeaturedPlaylist::destroy($id);

        return redirect('admin/featured_playlist')->with('flash_message', 'Playlist deleted!');
    }
}

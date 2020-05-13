<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use App\Content;
use App\Stats;
use Illuminate\Http\Request;
use wapmorgan\Mp3Info\Mp3Info;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $songs = Song::orderBy('id', 'DESC')->paginate(10);;

        // dd($songs);

        return view('admin.songs.index', compact('songs'));
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

        // $audio = new Mp3Info($request->file('song'));
        
        // $duration = ($audio->duration)*1000; // duration in milliseconds
        // echo 'Audio duration: '.floor($audio->duration / 60).' min '.floor($audio->duration % 60).' sec'.PHP_EOL;
        // echo "\n";
        // echo 'Audio bitrate: '.($audio->bitRate / 1000).' kb/s'.PHP_EOL;
        // dd($duration);

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Content;
use App\Song;
use Illuminate\Http\Request;
use File;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class TracksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $contents = Content::where('cat_id', '=', "4")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('subtitle', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $contents = Content::where('cat_id', '=', "4")->latest()->paginate($perPage);
        }

        return view('admin.tracks.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tracks.create');
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
        $img_name = "";

        if($request->file('image')){
            $img_name = $this->uploadS3Data(@$request->file('image'), 'tracks');
        }

        $saveAlbum = Content::create($requestData);
        $saveAlbum->image = $img_name;
        $saveAlbum->subtitle = $requestData['subtitle'];
        $saveAlbum->save();
        return redirect('admin/tracks')->with('flash_message', 'Content added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $results = Content::findOrFail($id);

        $songs = Song::whereRaw('FIND_IN_SET("'.$id.'", content_id)')->orderBy('id', 'DESC')->get();

        return view('admin.tracks.show', compact('results', 'songs'));
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
        $content = Content::findOrFail($id);

        return view('admin.tracks.edit', compact('content'));
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

        $content = Content::findOrFail($id);
        $content->update($requestData);
        $content->subtitle = $requestData['subtitle'];
        $content->save();

        $img_name = "";
        
        if($request->file('image')){
            $img_name = $this->uploadS3Data(@$request->file('image'), 'tracks');

            $content->image = $img_name;
            $content->save();
        }


        return redirect('admin/tracks')->with('flash_message', 'Content updated!');
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
        Content::destroy($id);

        return redirect('admin/tracks')->with('flash_message', 'Content deleted!');
    }
}

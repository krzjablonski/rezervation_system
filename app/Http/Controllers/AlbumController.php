<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Photo;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::orderby('id', 'desc')->paginate(10);
        return view('albums.index')->withAlbums($albums);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $photos = Photo::all();
        return view('albums.create')->withPhotos($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $this->validate($request, array(
          'album_name' => 'required|max:255'
        ));

        // Create new album
        $album = new Album;

        // Sanitize album name
        $album->album_name = filter_var($request->album_name, FILTER_SANITIZE_STRING);

        // Save the album to database if success create relations
        if ($album->save()) {
          // Create relations
          $album->photos()->attach($request->photos);
          return redirect()->route('albums.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::find($id);

        return view('albums.show')->withAlbum($album);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find album
        $album = Album::find($id);

        // Get id's of photos assinged to this album
        foreach ($album->photos as $photo) {
          $photosId[] = $photo->id;
        }

        // Get all photos and order them to show photos assigned to this album id as first
        $photos = Photo::leftJoin('album_photo', 'photos.id', '=', 'photo_id')->orderByRaw(
          "CASE
            WHEN album_photo.album_id = $album->id THEN 1
            ELSE 2
            END"
          )->get();

        return view('albums.edit')->withAlbum($album)->withPhotos($photos)->withPhotosId($photosId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TO DO!!!
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find album
        $album = Album::find($id);

        // If album has relations remove them
        if($album->photos()->count() > 0){
          $album->photos->deatach();
        }

        // Destroy album
        $album->delete();

        return redirect()->route('albums.index');
    }
}

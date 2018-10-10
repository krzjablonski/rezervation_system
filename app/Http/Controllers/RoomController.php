<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Session;
use App\Feature;
use App\Album;
use App\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all rooms
        $rooms = Room::all();

        // Return view with all rooms
        return view('rooms.index')->withRooms($rooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $features = Feature::all();
        $albums = Album::all();
        $albumsArr = array();
        foreach ($albums as $album) {
          $albumsArr[$album->id] = $album->album_name;
        }
        return view('rooms.create-update')->withAlbums($albumsArr)->withFeatures($features);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $this->validate($request, array(
          'room_name' => 'required|max:255',
          'room_description' => 'required',
          'beds' => 'required|numeric',
          'size' => 'required|numeric',
          'album_id' => 'required|numeric'
        ));

        // sanitization
        $room_name = filter_var($request->room_name, FILTER_SANITIZE_STRING);
        $room_description = filter_var($request->room_description, FILTER_SANITIZE_STRING);
        $beds = filter_var($request->beds, FILTER_SANITIZE_NUMBER_INT);
        $size = filter_var($request->size, FILTER_SANITIZE_NUMBER_INT);
        $features = array();
        $album_id = filter_var($request->album_id, FILTER_SANITIZE_NUMBER_INT);
        foreach ($request->features as $feature) {
          $features[] = filter_var($feature, FILTER_SANITIZE_NUMBER_INT);
        }

        $room = new Room;
        $room->room_name = $room_name;
        $room->room_description = $room_description;
        $room->beds = $beds;
        $room->size = $size;
        $room->album_id = $album_id;

        if ($room->save()) {
          $room->feature()->sync($features);
          Session::flash('succes', 'Dodano pokój');
          return redirect()->route('rooms.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::find(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        $features = Feature::all();
        $featuresArr = array();
        foreach ($room->feature as $feature) {
          $featuresArr[] = $feature->id;
        }
        $albums = Album::all();
        $albumsArr = array();
        foreach ($albums as $album) {
          $albumsArr[$album->id] = $album->album_name;
        }
        return view('rooms.create-update')->withRoom($room)->withFeatures($features)->withFeaturesArr($featuresArr)->withAlbums($albumsArr);
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
      $this->validate($request, array(
        'room_name' => 'required|max:255',
        'room_description' => 'required',
        'beds' => 'required|numeric',
        'size' => 'required|numeric',
        'album_id' => 'required|numeric'
      ));

      // sanitization
      $room_name = filter_var($request->room_name, FILTER_SANITIZE_STRING);
      $room_description = filter_var($request->room_description, FILTER_SANITIZE_STRING);
      $beds = filter_var($request->beds, FILTER_SANITIZE_NUMBER_INT);
      $size = filter_var($request->size, FILTER_SANITIZE_NUMBER_INT);
      $features = array();
      $album_id = filter_var($request->album_id, FILTER_SANITIZE_NUMBER_INT);
      foreach ($request->features as $feature) {
        $features[] = filter_var($feature, FILTER_SANITIZE_NUMBER_INT);
      }

      $room = Room::find(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
      $room->room_name = $room_name;
      $room->room_description = $room_description;
      $room->beds = $beds;
      $room->size = $size;
      $room->album_id = $album_id;

      if ($room->save()) {
        $room->feature()->sync($features);
        Session::flash('succes', 'Dodano pokój');
        return redirect()->route('rooms.index');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        $room->feature()->detach();
        if ($room->delete()) {
          Session::flash('success', 'Usunięto pokój');
          redirect()->route('rooms.index');
        }else{
          Redirect::back()->withErrors('error', 'Nie można usunąć tego pokoju.');
        }
    }
}

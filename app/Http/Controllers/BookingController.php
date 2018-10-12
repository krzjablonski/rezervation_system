<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Room;

use Illuminate\Support\Facades\URL;

use Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomResourceCollection;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::all();

        return view('bookings.index')->withBookings($bookings);
    }

    /**
     * Display a listing of the resource with filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $this->validate($request, array(
          'check_in' => 'date',
          'check_out' => 'date'
        ));

        $bookingsId = $this->checkBooking($request->check_in, $request->check_out);

        $bookings = Booking::find($bookingsId);

        return view('bookings.index')->withBookings($bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bookings.create_search');
    }

    /**
     * Select available rooms.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\RoomResourceCollection
     */
    public function search(Request $request)
    {
      $this->validate($request, array(
        'check_in' => 'required|date',
        'check_out' => 'required|date'
      ));

      $bookingsArr = $this->checkRoom($request->check_in, $request->check_out);

      $rooms = Room::whereNotIn('id', $bookingsArr)->with('feature')->with('album.photos')->get();

      foreach ($rooms as $room) {
        $room->image_url = URL::to('/').'/uploads/'.$room->album->photos->first()->photo_path.'/'.$room->album->photos->first()->photo_thumbnail;
      }

      return new RoomResourceCollection($rooms);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
          'room_id' => 'required|integer',
          'check_in' => 'required|date',
          'check_out' => 'required|date',
          'customer_name' => 'required|max:255',
          'customer_email' => 'required|email',
          'customer_phone' => 'required|alpha_dash'
        ));



        if(in_array($request->room_id, $bookingsArr)){
          return Redirect::back()->withErrors(['error' => 'Wybrany pokój jest zarezerwowany w tym terminie']);
        }

        $booking = new Booking;
        $booking->room_id = filter_var($request->room_id, FILTER_SANITIZE_NUMBER_INT);
        $booking->check_in = filter_var($request->check_in, FILTER_SANITIZE_STRING);
        $booking->check_out = filter_var($request->check_out, FILTER_SANITIZE_STRING);
        $booking->customer_name = filter_var($request->customer_name, FILTER_SANITIZE_STRING);
        $booking->customer_email = filter_var($request->customer_email, FILTER_SANITIZE_SPECIAL_CHARS);
        $booking->customer_phone = filter_var($request->customer_phone, FILTER_SANITIZE_STRING);

        if ($booking->save()) {
          return redirect()->route('bookings.index');
        }else{
          return Redirect::back()->withErrors(['error' => 'Wystąpił problem z bazą danych. Spórbuj jeszcze raz']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function checkBooking($check_in, $check_out)
    {
      $bookings = Booking::select('id')
                        ->where([
                          ['check_out', '>', $check_in],
                          ['check_in', '<', $check_out]
                        ])
                        ->get();

      $bookingsArr = array();
      foreach($bookings as $booking){
        $bookingArr[] = $booking->id;
      }
      return $bookingArr;
    }

    protected function checkRoom($check_in, $check_out)
    {
      $bookings = Booking::select('room_id')
                        ->where([
                          ['check_out', '>', $check_in],
                          ['check_in', '<', $check_out]
                        ])
                        ->get();

      $bookingsArr = array();
      foreach($bookings as $booking){
        $bookingsArr[] = $booking->room_id;
      }
      return $bookingsArr;
    }
}

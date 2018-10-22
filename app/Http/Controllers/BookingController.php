<?php

namespace App\Http\Controllers;

use App\Exceptions\RoomsNotFoundException;
use App\Http\Resources\ErrorResource;
use Illuminate\Http\Request;
use App\Repositories\BookingRepository;
use App\Booking;

use Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\RoomResourceCollection;

class BookingController extends Controller
{

    protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
      $this->bookingRepo = $bookingRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return view bookings.index
     */
    public function index(Request $request)
    {
        if ($request->check_in || $request->check_out){

            // Validate request if there where send data
            $this->validate($request, [
                'check_in' => 'date',
                'check_out' => 'date'
            ]);

            // Get bookings from repository by filter method
            $bookings = $this->bookingRepo->filter($request->check_in, $request->check_out);
        }else{

            // If there where no check in and check out given get all bookings
            $bookings = Booking::all();

        }

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
     * @param  \Illuminate\Http\Request $request
     * @return RoomResourceCollection
     */
    public function search(Request $request)
    {
      $this->validate($request, [
        'check_in' => 'required|date',
        'check_out' => 'required|date'
      ]);

      try{
          $rooms = $this->bookingRepo->search($request->check_in, $request->check_out);
      }catch (RoomsNotFoundException $e){
          return new ErrorResource($e->getMessage());
      }


      return new RoomResourceCollection($rooms);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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

        $bookings = $this->bookingRepo->check($request->check_in, $request->check_out);

        $bookingsArr = array();

        $bookings->map(function ($item, $key){
            if ($key == 'id') {
                $bookingsArr[] = $item;
            }
        });

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

        return $booking->save() ? redirect()->route('bookings.index') : Redirect::back()->withErrors(['error' => 'Wystąpił problem z bazą danych. Spórbuj jeszcze raz']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO 
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
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO
    }
}

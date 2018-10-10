<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

use Session;
use Illuminate\Routing\Redirector;

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
        $bookings = Booking::where('check_in', filter_var($request->check_in, '>', FILTER_SANITIZE_STRING))->where('check_out', filter_var($request->check_in, '<', FILTER_SANITIZE_STRING))->get();

        return view('bookings.index')->withBookings($bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}

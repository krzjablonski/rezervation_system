<?php

namespace App\Repositories;

use App\Booking;
use App\Exceptions\RoomsNotFoundException;
use App\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\URL;

class BookingRepository
{
    /**
     * @param $check_in
     * @param $check_out
     * @return Laravel Collection of bookings
     */
    public function check($check_in, $check_out)
  {
    $bookings = Booking::where([
                        ['check_out', '>', $check_in],
                        ['check_in', '<', $check_out]
                      ])
                      ->get();
    return $bookings;
  }

    /**
     * @param $check_in
     * @param $check_out
     * @return Laravel Collection of bookings
     */
    public function filter($check_in, $check_out)
  {
      $bookings = $this->check($check_in, $check_out);

      if (!$bookings) {
          return redirect()->route('bookings.index')->withErrors(['error' => 'Nie ma wolnych pokojów w tym terminie']);
      }

      $bookingsId = $bookings->pluck('id');

      return $bookings = Booking::findOrFail($bookingsId);
  }

    /**
     *
     */
    public function search($check_in, $check_out)
  {
      $bookings = $this->check($check_in, $check_out);

      $bookingsArr = $bookings->pluck('room_id');

      $rooms = Room::whereNotIn('id', $bookingsArr)->with('feature')->with('album.photos')->get();

      if ($rooms->isEmpty()){
          throw new RoomsNotFoundException();
      }

      foreach ($rooms as $room) {
          $room->image_url = URL::to('/').'/uploads/'.$room->album->photos->first()->photo_path.'/'.$room->album->photos->first()->photo_thumbnail;
      }

      return $rooms;
  }
}

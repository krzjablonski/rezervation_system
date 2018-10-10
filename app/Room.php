<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  public function album(){
    return $this->belongsTo('App\Album');
  }
  public function feature()
  {
    return $this->belongsToMany('App\Feature', 'feature_room', 'room_id', 'feature_id');
  }
  public function booking()
  {
    return $this->hasMany('App\Booking');
  }
}

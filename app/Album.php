<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
  public function photos()
  {
    return $this->belongsToMany('App\Photo', 'album_photo', 'album_id', 'photo_id');
  }
  public function rooms()
  {
    return $this->hasOne('App\Room');
  }
}

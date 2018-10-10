<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function albums()
    {
      return $this->belongsToMany('App\Album', 'album_photo', 'photo_id', 'album_id');
    }
}

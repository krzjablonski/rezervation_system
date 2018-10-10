<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function room(){
      return $this->belongsToMany('App\Room', 'feature_room', 'feature_id', 'room_id');
    }
}

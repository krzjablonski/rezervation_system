@extends('layouts.admin')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-between align-items-center">
        <h1>Wszystkie pokoje</h1>
        {{ Html::linkRoute('rooms.create', 'Dodaj nowy', null, ['class'=>'btn btn-primary']) }}
      </div>
      <div class="col-sm-12">
        <hr>
      </div>
    </div>
    <div class="row">
      @foreach ($rooms as $room)
        <div class="col-md-3">
          <div class="card">
            <img class="card-img-top" src="{{asset('uploads/'.$room->album->photos->first()->photo_path.'/'.$room->album->photos->first()->photo_thumbnail)}}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$room->room_name}}</h5>
              <p class="card-text">{{ substr($room->room_description, 0, 55).'[...]' }}}</p>
              {{ Html::linkRoute('rooms.edit', 'Edytuj', $room->id, ['class'=>'btn btn-primary']) }}
              {!! Form::open(['route'=>['rooms.destroy', $room->id], 'method'=>'DELETE', 'class'=>'d-inline-block']) !!}
                {{ Form::submit('Delete', ['class'=>'btn btn-danger']) }}
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

@stop

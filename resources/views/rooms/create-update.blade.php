{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title')
  @if(!empty($room))
    {{'Edytuj pokój'}}
  @else
    {{'Dodaj pokój'}}
  @endif
@stop

@section('styles')
  <style>

    .form-check-input{
      margin-left: 0;
    }
    .form-check-label{
      margin-left: 14px;
    }

  </style>
@stop

@section('content')
  <div class="row">
    <div class="col-sm-12 d-flex justify-content-between align-items-center">
      @if(!empty($room))
        <h1>Edytuj: {{$room->room_name}}</h1>
      @else
        <h1>Dodaj pokój</h1>
      @endif
    </div>
    <div class="col-sm-12">
      <hr>
    </div>
  </div>
    @if (!empty($room))
      {!! Form::model($room, ['route' => ['rooms.update', $room->id], 'method' => 'PUT', 'class' => 'row']) !!}
    @else
        {!! Form::open(['route' => 'rooms.store', 'class' => 'row']) !!}
    @endif
    <div class="col-md-8">
      {{ Form::label('room_name', 'Nazwa pokoju') }}
      {{ Form::text('room_name', null, ['class' => 'form-control mb-3']) }}
      {{ Form::label('room_description', 'Opis pokoju') }}
      {{ Form::textarea('room_description', null, ['class' => 'form-control']) }}
    </div>
@stop

@section('sidebar')
  <div class="col-md-4">
    <div class="card p-2">
      <h4 class="cart-title">Dodatkowe informacje</h4>
      {{ Form::label('beds', 'Ilość łóżek') }}
      {{ Form::number('beds', null, ['class' => 'form-control mb-3']) }}
      {{ Form::label('size', 'Powierzchnia w m2') }}
      {{ Form::number('size', null, ['class' => 'form-control mb-3']) }}
      {{ Form::label('album_id', 'Wybierz album') }}
      {{ Form::select('album_id', $albums, null, ['class' => 'form-control mb-3']) }}
      <h4>Udogodnienia</h4>
      <div class="row">
        @foreach ($features as $feature)
          <div class="form-check col-md-6 mb-3">
            @if(isset($featuresArr) && in_array($feature->id, $featuresArr))
              {{ Form::checkbox('features[]', $feature->id, false, ['class' => 'form-check-input', 'checked' => 'checked']) }}
              {{ Form::label('features', $feature->name, ['class' => 'form-check-label']) }}
            @else
              {{ Form::checkbox('features[]', $feature->id, false, ['class' => 'form-check-input']) }}
              {{ Form::label('features', $feature->name, ['class' => 'form-check-label']) }}
            @endif
          </div>
        @endforeach
      </div>
      {{ Form::submit('Zapisz', ['class' => 'btn btn-primary btn-block mt-3 mb-3']) }}
    </div>
  </div>
  {!! Form::close() !!}
@stop

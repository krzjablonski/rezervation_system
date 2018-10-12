@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-between align-items-center">
        <h1>Wszystkie Rezerwacje</h1>
        {{ Html::linkRoute('bookings.create', 'Dodaj nową rezerwację', null, ['class'=>'btn btn-primary']) }}
      </div>
      <div class="col-sm-12">
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        {!! Form::open(['route'=>'bookings.filter', 'class'=>'form-inline']) !!}
        <div class="form-group mb-2 mr-sm-4">
          {{ Form::label('check_in', 'Od daty:', ['class'=>'mr-2']) }}
          {{ Form::date('check_in', null, ['class'=>'form-control']) }}
        </div>
        <div class="form-group mb-2 mr-sm-4">
          {{ Form::label('check_out', 'Do daty:', ['class'=>'mr-2']) }}
          {{ Form::date('check_out', null, ['class'=>'form-control']) }}
        </div>
        <div class="form-group mb-2 mr-sm-2">
          {{ Form::submit('Filtruj', ['class'=>'btn btn-info']) }}
        </div>
        {!! Form::close() !!}
      </div>
      <div class="col-md-12">

      </div>
    </div>
    <div class="row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Pokój</th>
            <th scope="col">Data zakwaterowania</th>
            <th scope="col">Data wykwaterowania</th>
            <th scope="col">Imię i nazwisko</th>
            <th scope="col">Numer telefonu</th>
            <th scope="col">Adres email</th>
            <th>Status (nieaktywne)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bookings as $booking)
            <tr>
              <th scope="row">{{$booking->id}}</th>
              <td>{{$booking->room->room_name}}</td>
              <td>{{$booking->check_in}}</td>
              <td>{{$booking->check_out}}</td>
              <td>{{$booking->customer_name}}</td>
              <td>{{$booking->customer_phone}}</td>
              <td>{{$booking->customer_email}}</td>
              <td>-</td>
            </tr>
          @endforeach
        </tbody>
    </div>
  </div>
@stop

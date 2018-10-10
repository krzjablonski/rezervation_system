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
          {{ Form::date('check_in') }}
        </div>
        <div class="form-group mb-2 mr-sm-4">
          {{ Form::label('check_out', 'Do daty:', ['class'=>'mr-2']) }}
          {{ Form::date('check_out') }}
        </div>
        <div class="form-group mb-2 mr-sm-2">
          {{ Form::submit('Filtruj', ['class'=>'btn btn-info']) }}
        </div>
        {!! Form::close() !!}
      </div>
      <div class="col-md-12">

      </div>
    </div>
  </div>
@stop

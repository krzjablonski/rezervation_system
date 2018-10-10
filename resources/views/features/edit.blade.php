{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', 'Wszystkie właściwości')

@section('content')
  <div class="row">
    <div class="col-md-6 offset-md-3">
      {!! Form::model($feature, ['route' => ['features.update', $feature->id], 'method' => 'PUT']) !!}
        {{ Form::label('name', 'Wpisz nazwę') }}
        {{ Form::text('name', null, ['class' => 'form-control mb-3']) }}
        {{ Form::submit('Zapisz', ['class' => 'btn btn-primary btn-block']) }}
      {!! Form::close() !!}
    </div>
  </div>
@stop

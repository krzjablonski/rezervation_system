{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', 'Wszystkie właściwości')

@section('content')
  <div class="row">
    <div class="col-sm-12 d-flex justify-content-between align-items-center">
      <h1>Wszystkie Atrybuty</h1>
    </div>
    <div class="col-sm-12">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Liczba użyć w pokojach</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($features as $feature)
            <tr>
              <th>{{$feature->id}}</th>
              <td>{{$feature->name}}</td>
              <td>{{$feature->room()->count()}}</td>
              <td>
                {{ Html::linkRoute('features.edit', 'Edytuj', [$feature->id], ['class' => 'btn btn-info btn-sm']) }}
                {!! Form::open(['route' => ['features.destroy', $feature->id], 'method' => 'DELETE', 'style' => 'display:inline-block']) !!}
                  {{ Form::submit('Usuń', ['class' => 'btn btn-danger btn-sm']) }}
                {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@stop

@section('sidebar')
  <div class="col-md-4">
    <div class="card p-3">
      <h4 class="card-title">Dodaj atrybut</h4>
      {!! Form::open(['route' => 'features.store']) !!}
        {{ Form::label('name', 'Wpisz nazwę') }}
        {{ Form::text('name', null, ['class' => 'form-control mb-3']) }}
        {{ Form::submit('Zapisz', ['class' => 'btn btn-primary btn-block']) }}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop

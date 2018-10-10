{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', 'Wszystkie Albumy')

@section('content')
  <div class="row align-items-center">
    <div class="col-md-6 offset-md-1">
      <h1>Wszystkie albumy</h1>
      <p class='small'>Znaleziono: {{$albums->count()}} albumów</p>
    </div>
    <div class="col-md-4">
      {{ Html::linkRoute('albums.create', 'Dodaj album', array(), array('class' => 'btn btn-primary btn-block')) }}
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nazwa albumu</th>
            <th>Ilość zdjęć</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($albums as $album)
            <tr>
              <th>{{$album->id}}</th>
              <td>{{ Html::linkRoute('albums.show', $album->album_name, array($album->id)) }}</td>
              <td>{{$album->photos()->count()}}</td>
              <td>
                {{ Html::linkRoute('albums.edit', 'Edytuj', array($album->id), array('class' => 'btn btn-danger')) }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop

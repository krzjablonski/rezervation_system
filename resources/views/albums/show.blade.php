{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', $album->album_name)

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
@stop

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
@stop

@section('content')

<div class="row align-items-center">
  <div class="col-md-8">
    <h1>{{$album->album_name}}</h1>
    <p class='small'>Znaleziono: {{$album->photos()->count()}} zdjęć w tym albumie</p>
  </div>
  <div class="col-md-4">
    {{ Html::linkRoute('albums.edit', 'Edytuj album', array($album->id), array('class' => 'btn btn-primary btn-block')) }}
  </div>
  <hr>
</div>

<div class="row">
  @foreach ($album->photos as $photo)
    <div class="col-md-3 image-select mt-3">
      <div class="image-container shadow-sm">
        <a data-fancybox="gallery" href="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_name)}}">
          <img class="img-fluid" src="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_thumbnail)}}" alt="{{$photo->photo_alt}}">
        </a>
      </div>
    </div>
  @endforeach
</div>

@stop

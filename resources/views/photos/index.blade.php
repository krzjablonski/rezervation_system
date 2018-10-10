{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', 'Wszystkie Zdjęcia')

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
  <style>
  .fa-times{
    background-color: red;
    color: white;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    cursor: pointer;
  }
  .delete_img_btn{
    position: absolute;
    top: 0;
    right: 15px;
    padding:0;
    background-color: transparent;
    border:none;
  }
  </style>
@stop

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
@stop

{{-- Main content --}}
@section('content')
  <div class="row">
    <div class="col">
      <h1>Wszystkie zdjęcia</h1>
      <p class='small'>Znaleziono: {{$photos->count()}} zdjęć</p>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="row row-eq-height">
        @if ($photos->count() == 0)
          <div class="alert alert-warning" role="alert">
            Nie dodano obrazów. Po dodaniu zdjęcia będą wyświetlono w tym miejscu.
          </div>
        @endif
        @foreach ($photos as $photo)
          <div class="col-md-3 image-select mb-3">
            <div class="image-container shadow-sm">
              <a data-fancybox="gallery" href="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_name)}}">
                <img class="img-fluid" src="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_thumbnail)}}" alt="{{$photo->photo_alt}}">
              </a>
              {!! Form::open(['route' => ['photos.destroy', $photo->id], 'method' => 'DELETE']) !!}
                {{ Form::button('<i class="fas fa-times"></i>', ['class' => 'delete_img_btn', 'type' => 'submit']) }}
              {!! Form::close() !!}
            </div>
          </div>
        @endforeach
      </div>
    </div>

@stop

{{-- Sidebar --}}
@section('sidebar')
    <div class="col-md-4 card pt-3 pb-3">
      <h4 class="card-title">Dodaj nowe zdjęcie</h4>
      {!! Form::open(['route' => 'photos.store', 'files' => true, 'method' => 'POST']) !!}
        {{ Form::label('image', 'Wybierz zdjęcie:') }}
        {{ Form::file('image', ['class' => 'form-control mb-3']) }}
        {{ Form::label('photo_alt', 'Alt tag:') }}
        {{ Form::text('photo_alt', null, ['class' => 'form-control mb-3']) }}
        {{ Form::submit('Wgraj zdjęcie', ['class' => 'btn btn-primary btn-block']) }}
      {!! Form::close() !!}
      <div class="progress mt-2">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    </div>
  </div> {{-- End of row --}}
@stop

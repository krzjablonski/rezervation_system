{{-- Layout --}}
@extends('layouts.admin')

{{-- Title of the page --}}
@section('title', 'Dodaj album')

@section('scripts')
  <script type="text/javascript" src="{{asset('js/checked.js')}}"></script>
@stop

@section('content')
  <div class="row">
    <div class="col-md-121">
      <h1>Dodaj album</h1>
      <p class='small'>Wypełnij formularz, żeby stworzyć nowy album</p>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-12">
      {{ Form::open(['route' => 'albums.store']) }}
      {{ Form::label('album_name', 'Nazwa albumu')}}
      {{ Form::text('album_name', null, array('class' => 'form-control mb-3')) }}
    </div>
    <div class="col-md-8">
      <h5 class='mb-3 mt-5'>Wybierz zdjęcia do tego albumu</h5>
      <div class="row">
        @foreach ($photos as $photo)
          <div class="col-md-4 image-select mt-3">
            <div class="image-container shadow-sm">
              <label><img class="img-fluid" src="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_thumbnail)}}" alt="{{$photo->photo_alt}}">
                {{ Form::checkbox('photos[]', $photo->id) }}
              </label>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mt-3 p-3">
        <h5 class='card-title mt-2'>Zapisz album</h5>
        {{ Form::submit('Zapisz', array('class' => 'btn btn-primary btn-block mt-5 mb-2')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>

  {{-- <div class="row mt-3">
    <div class="col-md-12">
      {{ Form::open(['route' => 'albums.store']) }}
        {{ Form::label('album_name', 'Nazwa albumu')}}
        {{ Form::text('album_name', null, array('class' => 'form-control mb-3')) }}
        <h5 class='mb-3 mt-5'>Wybierz zdjęcia do tego albumu</h5>
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              @foreach ($photos as $photo)
                <div class="col-md-4 image-select mt-3">
                  <div class="image-container shadow-sm">
                    <label><img class="img-fluid" src="{{asset('uploads/'.$photo->photo_path.'/'.$photo->photo_thumbnail)}}" alt="{{$photo->photo_alt}}">
                      {{ Form::checkbox('photos[]', $photo->id) }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="col-md-4 card pt-5">
            <h5>Zapisz album</h5>
            {{ Form::submit('Zapisz', array('class' => 'btn btn-primary')) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div> --}}
@stop

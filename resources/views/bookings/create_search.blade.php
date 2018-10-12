@extends('layouts.admin')

@section('styles')
  <style>
  .image{
    width:100%;
    height: 100%;
  }
  .image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  </style>
@stop

@section('content')
  <div class="row">
    <div class="col-sm-12 d-flex justify-content-between align-items-center">
      <h1>Sprawdź wolne pokoje</h1>
    </div>
    <div class="col-sm-12">
      <hr>
    </div>
  </div>
  <div class="row">
    <div v-if="check_in" class="col-md-12">
      <h5>@{{check_in }} - @{{check_out}}<h5>
    </div>
    <div class="col-md-12 d-flex align-items-end">
      <div v-if='search' class="form-group pr-4 mb-0">
        <label for="check_in">Data zakwaterowania</label>
        <input class="form-control" type="date" name="check_in" value="" v-model="check_in">
      </div>
      <div v-if='search' class="form-group pr-4 mb-0">
        <label for="check_out">Data wykwaterowania</label>
        <input class="form-control" type="date" name="check_out" value="" v-model="check_out">
      </div>
      <button v-if='search' class="btn btn-primary" type="button" name="button" @click="getAvRooms">Sprawdź</button>
      <button v-if='!search' class="btn btn-primary" type="button" name="button" @click="resetAll">Szukaj ponownie</button>
    </div>
  </div>
  <div class="row">
    <div v-for="room in rooms" class="col-sm-12 pt-4">
      <div class="">
        <div class="row">
          <div class="col-md-2 pr-0">
            <div class="image">
              <img :src="room.image_url" alt="">
            </div>
          </div>
          <div class="col-md-10 border pl-0">
            <div class="room_container pl-3 pt-3 pb-3">
              <h4>@{{room.room_name}}</h4>
              <hr>
              <p>@{{room.room_description}}</p>
              <div class="features">
                <span><strong>Atrybuty:</strong></span>
                <span v-for="feature in room.feature"> @{{feature.name}} </span>
              </div>
              <div class="book_form pt-2">
                <button type="button" name="button" class="btn btn-primary" @click="selectRoom(room.id, room.room_name)" data-toggle="modal" data-target="#bookingModal">Rezerwuj</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <!-- Modal -->
  <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="Nowa rezerwacja" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Nowa rezerwacja dla pokoju:<br><small>@{{selectedRoomName}}</small></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="" method="post">
            <span>Od: @{{check_in}} Do: @{{check_out}}</span>
            <hr>
            <div class="form-group">
              <label for="customer_name">Imię i Nazwisko</label>
              <input name="customer_name" type="text" class="form-control" id="customer_name">
            </div>
            <div class="form-group">
              <label for="customer_email">Email</label>
              <input name="customer_email" type="email" class="form-control" id="customer_email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="customer_phone">Numer telefonu</label>
              <input name="customer_phone" type="text" class="form-control" id="customer_phone">
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="room_id" :value="selectedRoomId">
            <input type="hidden" name="check_in" :value="check_in">
            <input type="hidden" name="check_out" :value="check_out">
            <input type="submit" name="submit" value="Zapisz" class="btn btn-success btn-block">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
        </div>
      </div>
    </div>
  </div>

@stop

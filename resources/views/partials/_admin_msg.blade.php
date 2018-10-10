@if($errors->any())
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="alert alert-danger" role="alert">
          <strong>Błąd:</strong>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endif

@if (Session::has('success'))
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="alert alert-success" role="alert">
          <strong>Sukces:</strong> {{Session::get('success')}}
        </div>
      </div>
    </div>
  </div>
@endif

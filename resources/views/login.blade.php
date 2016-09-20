@extends('layout')
@section('title','Login')
@section('header-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_home.css') }}">
@endsection
@section('header-js')
    <script type="text/javascript" src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection

@section('body')
    <div class="ds-nav">
  <h4 class="no-margin-top">KEY &middot; GAME</h4>
  <h5><a href="{{ route('keygame') }}" class="btn btn-info btn-xs"><strong>&larr; Home</strong></a></h5>
  <hr>
</div>
<div class="container-fluid main-container">
  <div class="row inner-container">
    <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 text-left login-container">
      <form method="post" action="{{ url('login') }}">
      {{ csrf_field() }}
        @if($errors->any())
          <div class="text-center alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <string>{{ $errors->first('wrong') }}</string>
          </div>
        @endif
        <div class="form-group">
          <label for="email">First Name</label>
          <input tabindex="1" type="text" class="form-control input-sm" id="fname" name="fname" value="{{ old('fname') }}" required>
        </div>
        <div class="form-group">
          <label for="email">Last Name</label>
          <input tabindex="2" type="text" class="form-control input-sm" id="lname" name="lname" value="{{ old('lname') }}" required>
        </div>
        <div class="form-group">
          <label for="email">User Name</label>
          <input tabindex="3" type="text" class="form-control input-sm" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input tabindex="4" type="password" class="form-control input-sm" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="email">Enrollment</label>
          <input tabindex="5" type="number" class="form-control input-sm" id="enrollment" name="enrollment" min="100000000000" max="999999999999" value="{{ old('enrollment') }}" required>
        </div>
        <button tabindex="5" type="submit" class="btn btn-info btn-block btn-sm"><strong>Login</strong> - Let's Roll</button>
      </form>
    </div>
  </div>
</div>
<p class="ds-bottom-text">Brought to you by <strong>Mahesh Bhuva</strong></p>
    </body>
@endsection
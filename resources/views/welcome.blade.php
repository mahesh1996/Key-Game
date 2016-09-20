@extends('layout')

@section('title','Key Game')
@section('header-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_home.css') }}">
@endsection
@section('header-js')
    <script type="text/javascript" src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection

@section('body')
<div class="ds-nav">
  <h4 class="no-margin-top"><strong>Key.Game</strong></h4>
  <h5><a class="btn btn-info btn-xs"><strong>Typing Speed Game</strong></a></h5>
  <hr>
</div>
<div class="container-fluid main-container">
  <div class="row inner-container text-center">
    <h3 class="no-margin-top">KEEP CALM</h3>
    <h4>AND</h4>
    <h3 class="no-margin-top">MAKE YOUR HANDS READY</h3>
    <p><a href="{{ route('login') }}" class="btn btn-info btn-sm"><strong>Login</strong> - Let's Roll</a></p>
  </div>
</div>
<p class="ds-bottom-text">Brought to you by <strong>Mahesh Bhuva</strong></p>
@stop
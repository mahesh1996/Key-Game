@extends('layout')
@section('title','Home')
@section('header-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/timeTo.css') }}">
    <style>
      .container{
        margin-top: 20px;
      }
      .label{
        //margin:0 5px;
        letter-spacing: 1px;
        font-weight: 400;
      }
      .color-success{
        color: blue;
      }
      .data{
        display: inline-block;
        margin: 10px 2px;
      }
      #myModal{
        position:fixed;
        margin:0 auto;
        left:0;
        right:0;
        top:0;
        text-align: center;
      }
      .modal-inner{
        display: inline-block;
      }
      button.score{
        margin-top:8px;
      }
      #score-board{
        height: 200px;
        overflow: scroll;
      }
      .databox{
        padding:60px;
      }
    </style>
@endsection
@section('header-js')
    <script type="text/javascript" src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection

@section('body')
    <body>
      <input type="hidden" name="userid" id="userid" value="{{$userid}}">
    <div class="container clearfix" id="container">
      <nav class="navbar navbar-default navbar-fixed-top" id="navbar">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Keyboard Gamer</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Name: {{$name}}</a></li>
                <li><a href="#" id="timerStarter" class="">Start</a></li>
                <li><a href="#" id="finish" class="">Finish</a></li>               
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('logout') }}">Logout</a></li>
                <li role="separator" class="divider"></li>
                <li><button class="btn btn-primary score">Your Score <span class="badge" id="score"> {{$score}}</span> WPM</button>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      <h1>List of words</h1>
      <div class="row">
        <div class="col-md-12">
          <h3 id="keywordList"></h3>
        </div>
      </div>
    </div>
    <div id="myModal">
      <div class="row">
      <div  class="col-sm-3 col-sm-offset-1 height-300" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title text-center">Enter Keyword</h3>
            </div>
            <div class="modal-body text-center databox">
              <form>
                <div class="form-group">
                  <label for="email">Enter Keyword</label>
                  <input tabindex="1" type="text" class="form-control input-sm" id="databox" required>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>

      <div class="col-sm-3"><span id="clock"></span></div>

      <div class="col-sm-3" role="dialog">
        <div class="modal-dialog  modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-center">Score Board</h4>
            </div>
            <div class="modal-body text-center" id="score-board">
              <div>
                <table class="table">
                  <thead>
                    <tr>
                      <th class="text-center">Rank</th>
                      <th class="text-center">Player</th>
                      <th class="text-center">Score</th>
                    </tr>
                  </thead>
                  <tbody id="score-list">
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
      </div>
    </div>
    <script type="text/javascript" src="{{asset('js/timeto.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/keyboardgamer.js')}}"></script>
  </body>
@endsection
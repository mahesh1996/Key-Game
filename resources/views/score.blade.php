@extends('layout')
@section('title','Score Board')
@section('header-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
@endsection
@section('header-js')
    <script type="text/javascript" src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection

@section('body')
    <body class="">
        <div class="container">
          <h2>Player Score</h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Enrollment</th>
                  <th>Total word completed</th>
                  <th>Word Per Minute</th>
                  <th>Total Time Taken (in seconds)</th>
                </tr>
              </thead>
              <tbody id="scoreBox">
              </tbody>
            </table>
        </div>
        <script type="text/javascript">
          $('document').ready(function() {
            setInterval(updateScores, 1000);
          });
          function updateScores() {
            $.get('updateScores',function(data) {
              $('#scoreBox').html('');
              /*data.sort(function(a,b) {
                return parseInt(a.total_time) - parseInt(b.total_time);
              });*/
              for(var i=0; i<data.length; i++) {
                var html = '<tr>'
                  + '<td>' + data[i].fname+ ' ' + data[i].lname +'</td>'
                  + '<td>' + data[i].enrollment + '</td>'
                  + '<td>' + data[i].wpm_completed_word + '</td>'
                  + '<td>' + data[i].score + '</td>'
                  + '<td>' + (data[i].total_time == "In Progress" ? data[i].total_time : data[i].total_time/1000) + '</td>'
                + '</tr>';
                console.log(html);
                $('#scoreBox').append(html);
              }
            },'json');
          }
        </script>
    </body>
@endsection
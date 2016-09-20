var dataRecord;
var data = [];
var startTime = 0;
var endTime = 0;
var completedWord = 0;
var conn = new WebSocket('ws://localhost:8008');
    conn.onopen = function(e) {
      console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        console.log("data from server "+e.data);
        scoreBoard(e.data);
    };

$(document).ready(function(){
  $('#databox').prop('disabled',true);
  var navbarHeight = $('#navbar').outerHeight(true);
  $('#myModal').css('top', navbarHeight + 'px');
  $('#container').css('margin-top',($('#myModal').outerHeight(true) + navbarHeight) + 'px');
  checkUserStatus();
  $.get('getData',function(items){
    $.each(items,function(item,score){
      data.push(item);
    });
    initKeyboardGamer(items);
  },'json');
});

    var setFinishListener = function() {
      $('#finish').off().on('click', function(e) {
        e.preventDefault();
        //alert('hi');
        finishGame();
      });
    }
    var checkUserStatus = function() {
      $.get('status',function(data) {
        if(data.status == 'started') {
          $('#timerStarter').remove();
          $('#databox').prop('disabled',false);
          startClock();
          //setFinishListener();
          $.get('wpmStartTime', function(data) {
            startTime = parseInt(data.time);
            completedWord = data.completedWord;
            setInterval(publishScore, 500);  
          }, 'json');
          
        }
        else if(data.status == 'notstarted') {
          $('#timerStarter').on('click',function(e) {
            e.preventDefault();
            $.get('setStarted',function(data){},'json');
            $('#databox').prop('disabled',false);
            $(this).off();
            $(this).remove();
            //setFinishListener();
            startClock();
            startTime = new Date().getTime();
            setInterval(publishScore, 500);
          });
        }
      }, 'json');
    }

    var startClock = function(){
      $.get('clock',function(data){
        $('#clock').timeTo({
          seconds: data.time,
          fontFamily: 'inherit',
          callback: function() {
            //alert('done');
            //window.location.assign('mbz/finish');
            finishGame();
          }
        });
      },"json");
    }
      

      function initKeyboardGamer(data) {
        dataRecord = data;

        $.each(data,function(item,score){
          //console.log(key);
            $('#keywordList').append('<p class="data"><span class="label label-'+ (score == 1 ? 'success' : 'danger') +'" id="' + item + '">' +  item + '</span></p>');

          //dataRecord[item] = 0;
        });

        $('#databox').on('keyup',function(e){
          //console.log(e.keyCode);
          if(e.keyCode == 40) {
            var current = $(document).scrollTop();
            $('html, body').animate({
                scrollTop: current + 200
            }, 100);
          }
          else if(e.keyCode == 38) {
            var current = $(document).scrollTop();
            $('html, body').animate({
                scrollTop: current - 200
            }, 100);
          }
          else
            checKeyword(this.value);
        });
      }

      function checKeyword(item){
        var index = $.inArray(item, data) > -1;

        if(index && dataRecord[item] != 1) {
          completedWord++;
          $('#'+item).removeClass('label-danger').children().removeClass('color-success').end().addClass('label-success');
          dataRecord[item] = 1;
          $('#databox').val('');
        }
        else {
          $.each(data,function(i,tempItem){
            $('#' + tempItem).children().removeClass('color-success');
            if(tempItem.startsWith(item) && dataRecord[tempItem] != 1){
              var formatted = '<span class="color-success">'+ item +'</span>';
              formatted += tempItem.substring(item.length, tempItem.length);
              $('#' + tempItem).html(formatted);
            }
          });
        }
      }
      
      function scoreBoard(scoreData){
        $('#score-list').html('');
        var temp = JSON.parse(scoreData);
        //console.log(temp.length);
        for (var i = 0; i < temp.length; i++) {
          //console.log(temp[i].fname);
          var html = '<tr class="success">'
            + '<td>' + (i+1) +'</td>'
            + '<td>' + temp[i].fname+' ' + temp[i].lname + '</td>'
            + '<td>' + temp[i].score + '</td>'
          + '</tr>';
          $('#score-list').append(html);
        }
      }
      function publishScore(){
        if(completedWord > 10) {
          setFinishListener();
        }
        endTime = new Date().getTime();
        var score = (60 * completedWord) / ((endTime - startTime)/1000);
        $('#score').html(score);
        console.log("score = "+score);
        conn.send(JSON.stringify([dataRecord, {'userid' : $('#userid').val(), 'wpmStartTime' : startTime, 'score' : score, 'completedWord' : completedWord}]));
      }
      function finishGame() {
        $.get('finish',{'endTime' : new Date().getTime() },function(data) {
          window.location.href = 'score';
        },'json');
      }
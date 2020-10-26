//파일 드래그&드롭
var fileobj;
function upload_file(e) {
  e.preventDefault();
  fileobj = e.dataTransfer.files;
  ajax_file_upload(fileobj);
}

function ajax_file_upload(file_obj) {
  if(file_obj != undefined) {
    var form_data = new FormData(); 
    
    for (var i=0;i<file_obj.length;i++)
    {
      form_data.append('file', file_obj[i]);
    }                 

    $.ajax({
      type: 'POST',
      url: 'uploadprocess.php',
      contentType: false,
      processData: false,
      data: form_data,
      success:function() {
        $('#selectfile').val('');
      window.location.reload();
      }
    });
  }
}

//폴더생성
function popup_open(){
  var popupWidth = 400;
  var popupHeight = 200;
  var popupX = (window.screen.width / 2) - (popupWidth / 2);
  var popupY= (window.screen.height / 2) - (popupHeight / 2);
  window.open('mkdir.php', '새 폴더 만들기', 'status=no, height='+popupHeight+',width='+popupWidth+',left='+popupX+',top='+ popupY);
}

//이미지 뷰어
function img_open(file){
  img_close();

  var imgview = document.getElementById('imgview');
  var img = document.createElement('img');

  img.id = "img_tag";
  img.src = file;

  img.onload = function(){
    var MAX_WIDTH = 1000;
    var MAX_HEIGHT = 700;
    var div_width = $('.storage').width();
    var div_height = $('.storage').height();

    if(this.width > div_width){
      this.width = div_width / 2;
    }
    else if(this.height > div_height){
      this.height = div_height /2;
    }
    else{
      if(this.width > MAX_WIDTH){
        this.width = MAX_WIDTH;
      }
      else if(this.height > MAX_HEIGHT){
        this.height = MAX_HEIGHT;
      }
    }

    var move_width = (div_width / 2) - (this.width / 2);
    var move_height = (div_height / 2) - (this.height / 2);

    $('#img_tag').css({
      left : move_width,
      top : move_height
    });
  };

  imgview.appendChild(img);
  $('.imgview').show();
}

function img_close(){
  var imgview = document.getElementById('imgview');
  var img = document.getElementById('img_tag');

  if(img !== null){
    imgview.removeChild(img);
  }
}

function img_hide(){
  img_close();
  $('.imgview').hide();
}

//우클릭 파일 삭제 이벤트
function remove_file(){
  var i;
  var element = document.getElementsByClassName('selected');

  //php파일로 데이터 전송
  for(i = 0; i <element.length; i++){
    $.ajax({
      type: 'POST',
      url: 'remove_file.php',
      data: {'element' : element[i].id}
    }).done(function(){
      window.location.reload();
    });
  }

}


//드래그
jQuery(function($){
  $(".storage")
    .drag("start",function(){
      $( '.drop' ).removeClass("selected");
      $( '.drop' ).removeClass("dropped");

      return $('<li class="selection" />')
        .css('opacity', .60 )
        .appendTo( document.body );
    })
    .drag(function( ev, dd ){
      $( dd.proxy ).css({
        top: Math.min( ev.pageY, dd.startY ),
        left: Math.min( ev.pageX, dd.startX ),
        height: Math.abs( ev.pageY - dd.startY ),
        width: Math.abs( ev.pageX - dd.startX )
      });
    })
    .drag("end",function( ev, dd ){
      $( dd.proxy ).remove();
    });

  //드래그 된 파일 클래스 변경
  $('.drop')
    .drop("start",function(){
      $( this ).addClass("active");
    })
    .drop(function(){
      $( this ).toggleClass("dropped selected");
    })
    .drop("end",function(){
      $( this ).removeClass("active");
    });

    $.drop({ multi: true });	
});

//우클릭 메뉴
$(document).ready(function(){
  $(".drop").contextmenu(function(e)
  {
    if (!$(this).hasClass("selected")) {
      $(".drop").removeClass("dropped");
      $(".drop").removeClass("selected");
      $(this).addClass("selected");
    }
    

    if($(".selected").length < 2)
    {
      $(".drop").removeClass("selected");
      $(this).addClass("dropped");
      $(this).addClass("selected");
    }


    //윈도우 사이즈 계산
    var winWidth = $(document).width();
    var winHeight = $(document).height();

    //포인터 위치
    var posX = e.pageX;
    var posY = e.pageY;

    //메뉴창 크기 계산
    var menuWidth = $(".contextmenu").width();
    var menuHeight = $(".contextmenu").height();

    var secMargin = 10;

    if(posX + menuWidth + secMargin >= winWidth && posY + menuHeight + secMargin >= winHeight){
      posLeft = posX - menuWidth - secMargin + "px";
      posTop = posY - menuHeight - secMargin + "px";
    }

    else if(posX + menuWidth + secMargin >= winWidth){
      posLeft = posX - menuWidth - secMargin + "px";
      posTop = posY + secMargin + "px";
    }

    else if(posY + menuHeight + secMargin >= winHeight){
      posLeft = posX + secMargin + "px";
      posTop = posY - menuHeight - secMargin + "px";
    }

    else {
      posLeft = posX + secMargin + "px";
      posTop = posY + secMargin + "px";
    };

    //메뉴창 CSS
    $(".contextmenu").css({
      "left": posLeft,
      "top": posTop
    }).show();

    return false;
  });


  //메뉴창 숨기기
  $(document).click(function()
  {
    $(".storage").mousedown(function(e)
    {
      if(e.which == 1){
        $(".drop").removeClass("dropped");
        $(".drop").removeClass("selected");
        $(".contextmenu").hide();
      }
    })
  });

});


//우클릭으로 파일 다운로드
function download_file()
{
  var i;
  var elementlist = document.getElementsByClassName('dropped');

  if(elementlist.length<6)
  {
    //php파일로 데이터 전송
    for(i = 0; i <elementlist.length; i++){
      var element= elementlist[i].id;

      var aIframe = document.createElement("iframe");
      aIframe.style.display='none';
      aIframe.src = "download.php?file_name="+element;

      document.body.appendChild(aIframe);
    }

  }
  else  //선택파일이 5개가넘으면 압축해서 다운
  {

  }


  var frame=document.getElementsByTagName('iframe');
  var timer = setInterval(function () {
    for (i=0;i<frame.length;)
    {
      var iframeDoc = frame[i].contentDocument || frame[i].contentWindow.document;
      // Check if loading is complete
      if (iframeDoc.readyState == 'complete' || iframeDoc.readyState == 'interactive') {
        document.body.removeChild(frame[i]);
        if(!frame)
        {
          clearInterval(timer);
          return;
        }
      }
    }
  }, 4000); 
  
}


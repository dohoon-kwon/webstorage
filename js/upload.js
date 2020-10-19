//파일 드래그&드롭
var fileobj;
function upload_file(e) {
  console.log("upload");
  e.preventDefault();
  fileobj = e.dataTransfer.files[0];
  ajax_file_upload(fileobj);
  console.log("upload2");
}

function ajax_file_upload(file_obj) {
  if(file_obj != undefined) {
      console.log(file_obj);
      var form_data = new FormData();                  
      form_data.append('file', file_obj);
    $.ajax({
      type: 'POST',
      url: 'uploadprocess.php',
      contentType: false,
      processData: false,
      data: form_data,
      success:function(value) {
        alert(value);
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
    .drag("start",function( ev, dd ){
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
    .drop(function( ev, dd ){
      $( this ).toggleClass("dropped");
    })
    .drop("end",function(){
      $( this ).removeClass("active");
    });

    $.drop({ multi: true });	
});

//우클릭 메뉴
$(document).ready(function(){
  $(".storage li").contextmenu(function(e){
    $(this).addClass("selected");

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
  $(document).click(function(){
    $(".storage li").removeClass("selected");
    $(".contextmenu").hide();
  });
});


//우클릭으로 파일 다운로드
function download_file(){
  var i;
  var element = document.getElementsByClassName('selected');

  //php파일로 데이터 전송
  for(i = 0; i <element.length; i++){
    multiple_donwload(i);
  }
}

function multiple_donwload(i)
{
  location.href="download.php?file_name="+element[i].id;
}
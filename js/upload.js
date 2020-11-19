//파일 드래그&드롭
var fileobj;

function upload_file(e) 
{
  e.preventDefault();
  fileobj = e.dataTransfer.files;
  ajax_file_upload(fileobj);
}


//업로드
function ajax_file_upload(file_obj) 
{
  if(file_obj != undefined) 
  {
    var form_data = new FormData(); 
    
    for (var i=0;i<file_obj.length;i++)
    {
      form_data.append('file'+i, file_obj[i]);
    }

    $('.loading_div').show();                 

    $.ajax({
      type: 'POST',
      url: 'uploadprocess.php',
      contentType: false,
      processData: false,
      data: form_data,
      success:function() {
        $('#selectfile').val('');
        window.location.reload();
        $('.loading_div').hide();   
      }
    });
  }
}


//공유폴더파일 드래그&드롭
var fileobj;
function upload_share_file(e) {
  e.preventDefault();
  fileobj = e.dataTransfer.files;
  ajax_share_file_upload(fileobj);
}

function ajax_share_file_upload(file_obj) {
  if(file_obj != undefined) {
    var form_data = new FormData(); 
    
    for (var i=0;i<file_obj.length;i++)
    {
      form_data.append('file'+i, file_obj[i]);
    }
    
    $('.loading_div').show();  

    $.ajax({
      type: 'POST',
      url: 'share_uploadprocess.php',
      contentType: false,
      processData: false,
      data: form_data,
      success:function() {
        $('#selectfile').val('');
        window.location.reload();
        $('.loading_div').hide(); 
      }
    });
  }
}


//폴더생성
function mkdir_open(){
  $('.mkdirview').show();
}


//폴더 생성 취소
function mkdir_cancle(){
  $('.mkdirview').hide();
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

    if(this.width > div_width)
    {
      this.width = div_width / 2;
    }
    else if(this.height > div_height)
    {
      this.height = div_height /2;
    }
    else
    {
      if(this.width > MAX_WIDTH)
      {
        this.width = MAX_WIDTH;
      }
      else if(this.height > MAX_HEIGHT)
      {
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

//이미지 닫기
function img_close(){
  var imgview = document.getElementById('imgview');
  var img = document.getElementById('img_tag');

  if(img !== null)
  {
    imgview.removeChild(img);
  }
}

//이미지 숨기기 >> 닫기 기능 사용
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
      url: 'remove_file.php?mode=remove',
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
        .css('opacity', .60)
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
  fadeIO();

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
        //$(".msgmenu").hide();
      }
    })
  });
});

//우클릭으로 파일 다운로드
function download_file(){
  var i;
  var elementlist = document.getElementsByClassName('selected');

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
    
    var filelist=[];

    for (var i=0;i<elementlist.length;i++)
    {
      filelist[i]= elementlist[i].id;
    } 

    var aIframe = document.createElement("iframe");
    aIframe.style.display='none';
    aIframe.src = "lib/zipdownload.php?filelist="+JSON.stringify(filelist);
    document.body.appendChild(aIframe);
    
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

//휴지통 비우기
function trash_clear()
{
  var confirm_value = confirm("휴지통을 비우시겠습니까?");

  if( confirm_value == true )
  {
    $.ajax({
      url: 'remove_file.php?mode=clear'
    }).done(function(){
      window.location.reload();
    });
  }
}


//알림 확인 버튼
function msg_view()
{
  if($(".msgmenu").css("display") == 'none')
  {
    $(".msgmenu").show();
  }
  else
  {
    $(".msgmenu").hide();
  }
}


//전체 알림 삭제
function remove_msg_all(){
  var confirm_value = confirm("전체 알림을 삭제합니다.");

  if( confirm_value == true )
  {
    $.ajax({
      url: 'process.php?mode=msg_all_clear'
    }).done(function(){
      window.location.reload();
    });
  }
}


//읽은 알림 삭제
function remove_msg_read(){
  var confirm_value = confirm("읽은 알림을 삭제합니다.");

  if( confirm_value == true )
  {
    $.ajax({
      url: 'process.php?mode=msg_read_clear'
    }).done(function(){
      window.location.reload();
    });
  }
}


//파일 공유 >> 수정해야댐
function share_file(){
  var popupWidth = 400;
  var popupHeight = 200;
  var popupX = (window.screen.width / 2) - (popupWidth / 2);
  var popupY= (window.screen.height / 2) - (popupHeight / 2);
  window.open('share_file.html', '파일공유', 'status=no, height='+popupHeight+',width='+popupWidth+',left='+popupX+',top='+ popupY);
}

//파일공유 알림 클릭
function join_share(num,list){
  var confirm_value = confirm("해당 공유 폴더에 참여하시겠습니까?");

  if( confirm_value == true )
  {
    $.ajax({
      type: 'POST',
      url: 'process.php?mode=share_ok',
      data: {'pk_num' : num , 'user_list' : list}
    }).done(function(){
      window.location.reload();
    });
  }
  else
  {
    $.ajax({
      type: 'POST',
      url: 'process.php?mode=share_no',
      data: {'pk_num' : num}
    }).done(function(){
      window.location.reload();
    });
  }
}

//알림메세지 페이드효과
function fadeIO(){
  $('.msgcount').fadeOut(1000, function(){
    $('.msgcount').fadeIn(1000,function()
    {
      fadeIO();
    });
  });
}


//파일복원 휴지통 > 계정폴더
function restore_file()
{
  var i;
  var element = document.getElementsByClassName('selected');

  //php파일로 데이터 전송
  for(i = 0; i <element.length; i++){
    $.ajax({
      type: 'POST',
      url: 'process.php?mode=restore',
      data: {'element' : element[i].id}
    }).done(function(){
      window.location.reload();
    });
  }
}


//휴지통 파일 영구삭제 이벤트
function zap_file(){
  var confirm_value = confirm("파일을 영구삭제합니다.");

  if( confirm_value == true )
  {
    var i;
    var element = document.getElementsByClassName('selected');

    for(i = 0; i <element.length; i++){
      $.ajax({
        type: 'POST',
        url: 'remove_file.php?mode=zap',
        data: {'element' : element[i].id}
      }).done(function(){
        window.location.reload();
      });
    }
  }
}


//파일 정렬
function sort_file()
{
  
}
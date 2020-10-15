//파일 드래그&드롭
var fileobj;
function upload_file(e) {
  e.preventDefault();
  fileobj = e.dataTransfer.files[0];
  ajax_file_upload(fileobj);
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
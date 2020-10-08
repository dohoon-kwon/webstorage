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

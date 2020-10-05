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

<?php
    session_start();
    $id=$_SESSION['id'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>파일 저장소</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <nav>
        <ul>
            <li><a class="idinfo"><?=$id?>님 환영합니다.</a></li>
            <li><a class="logout" href="login.php">로그아웃</a></li>
        </ul>
        <ul class="top_menu">
            <li class="top_menu_item"><a href="main.php">홈페이지 정보</a></li>
            <li class="top_menu_item"><a href="upload.php">파일 저장소</a></li>
            <li class="top_menu_item"><a href="board.php">게시판 정보</a></li>
            <li class="top_menu_item"><a href="tool.php">홈페이지 관리</a></li>
        </ul>
    </nav>
    <div class="rightmenu">
        <ul>
            <li><input type="button" value="개인저장소"></li>
            <li><input type="button" value="공유저장소"></li>
            <li><input type="button" value="휴지통"></li>
            <li><h1>저장소 용량표시도 만들어야할까</h1></li>
        </ul>
    </div>
    <form enctype="multipart/form-data" action="uploadprocess.php" method="POST" class="leftmenu">
        <input type="hidden" name="MAX_FILE_SIZE" value="99999999999999999" />
        <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
        <input name="userfile" type="file" />
        <input type="submit" value="업로드" />
    </form>

    <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
          <div id="drag_upload_file">
            <p>Drop file here</p>
            <p>or</p>            
            <p><input type="button" value="Select File" onclick="file_explorer();"></p>
            <input type="file" id="selectfile" name="userfile">
          </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
      var fileobj;
      function upload_file(e) {
        e.preventDefault();
        fileobj = e.dataTransfer.files[0];
        ajax_file_upload(fileobj);
      }

      function file_explorer() {
        document.getElementById('selectfile').click();
        document.getElementById('selectfile').onchange = function() {
            fileobj = document.getElementById('selectfile').files[0];
          ajax_file_upload(fileobj);
        };
      }

      function ajax_file_upload(file_obj) {
        if(file_obj != undefined) {
            var form_data = new FormData();                  
            form_data.append('file', file_obj);
          $.ajax({
            type: 'POST',
            url: 'uploadprocess.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
              alert(response);
              $('#selectfile').val('');
            }
          });
        }
      }
    </script>

</body>
</html>
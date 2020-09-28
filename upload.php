<?php
    //세션
    session_start();
    $id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>파일 저장소</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/upload.css?ver=1">
</head>
<body>
    <nav>
        <ul>
            <li><a class="idinfo"><?=$id?>님 환영합니다.</a></li>
            <li><a class="logout" href="login.php">로그아웃</a></li>
        </ul>
        <ul class="top_menu">
            <li class="top_menu_item" onclick="location.href='upload.php'"><a>파일 저장소</a></li>
            <li class="top_menu_item" onclick="location.href='share.php'"><a>공유 저장소</a></li>
            <li class="top_menu_item" onclick="location.href='tool.php'"><a>홈페이지 관리</a></li>
        </ul>
    </nav>

    <div class="leftmenu">
        <ul>
            <li><h1>드라이브</h1></li>
            <li><a onclick="storage()">모든 파일</a></li>
            <li><a>사진</a></li>
            <li><a>동영상</a></li>
            <li><a>문서</a></li>
            <li><a onclick="trash()">휴지통</a></li>
            <li><h1>저장소 용량표시할 예정</h1></li>
        </ul>
    </div>

    <div class="rightmenu">
      <nav class="storage">
        <form enctype="multipart/form-data" action="uploadprocess.php" method="POST">
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
      </nav>

      <nav class="trash">
        <?php
          // 폴더명 지정
          $dir = "/home/samba/userfile/$id"."trash";
          // 핸들 획득
          $handle  = opendir($dir);
          $files = array();
          // 디렉터리에 포함된 파일을 저장한다.
          while (false !== ($filename = readdir($handle))) {
              if($filename == "." || $filename == ".."){
                  continue;
              }
              // 파일인 경우만 목록에 추가한다.
              if(is_file($dir . "/" . $filename)){
                  $files[] = $filename;
              }
          }
          // 핸들 해제 
          closedir($handle);
          // 정렬, 역순으로 정렬하려면 rsort 사용
          sort($files);
          // 파일명을 출력한다.
          foreach ($files as $f) {
              echo $f;
              echo "<br />";
          } 
        ?>
      </nav>      
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

      function storage(){
        $('.trash').hide();
        $('.storage').show();
      }
      function trash(){
        $('.trash').show();
        $('.storage').hide();
      }
    </script>

</body>
</html>
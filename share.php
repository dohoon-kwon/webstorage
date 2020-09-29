<?php
    //세션
    session_start();
    $id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>공유 저장소</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/upload.css">
  <script src="js/upload.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            <li><a onclick="trash()">휴지통</a></li>
            <li><h1>저장소 용량표시할 예정</h1></li>
        </ul>
    </div>

    <div class="rightmenu">

      <nav class="storage">
        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
            <div id="drag_upload_file">
              <ul id="file_list"></ul>
              <?php
                $dir = "/home/samba/userfile/";
                $handle  = opendir($dir);
                $files = array();
                while (false !== ($filename = readdir($handle))) {
                    if($filename == "." || $filename == ".."){
                        continue;
                    }
                    if(is_file($dir . "/" . $filename)){
                        $files[] = $filename;
                    }
                }
                closedir($handle);
                sort($files);
                foreach ($files as $f) {
                    echo $f;
                    echo "<br />";
                } 
              ?>
            </div>
        </div>
      </nav>
    
      <nav class="trash">
        <?php
          // 폴더명 지정
          $dir = "/home/samba/userfile/";
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

    <script type="text/javascript">
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
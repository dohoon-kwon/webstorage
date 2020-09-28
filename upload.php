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
  <link rel="stylesheet" href="css/upload.css">
  <script src="js/upload.js?ver=1"></script>
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
            <li><a onclick="photo()">사진</a></li>
            <li><a onclick="video()">동영상</a></li>
            <li><a onclick="document1()">문서</a></li>
            <li><a onclick="trash()">휴지통</a></li>
            <?php
               // 폴더 전체용량
              function dirsize($dir){
                static $size, $cnt;
                $fp = opendir($dir);
                while(false !== ($entry = readdir($fp))){
                      if(($entry != ".") && ($entry != "..")){
                          if(is_dir($dir.'/'.$entry)){
                                clearstatcache();
                                dirsize($dir.'/'.$entry);
                          } else if(is_file($dir.'/'.$entry)){
                                $size += filesize($dir.'/'.$entry);
                                clearstatcache();
                                $cnt++;
                          }
                      }
                }
                closedir($fp);

                $stat = array(
                          'size' => $size,
                          'cnt' => $cnt
                );
                return $stat;
                } // end func

                function attach($size) {
                if($size < 1024){
                      return number_format($size*1.024).'B';
                } else if(($size > 1024) && ($size < 1024000)){
                      return number_format($size*0.001024).'KB';
                } else if($size > 1024000){
                      return number_format($size*0.000001024,2).'MB';
                }
                return 0;
                }

                // 사용법: $arr = dirsize(폴더 경로);
                // $arr['cnt'] <- 총 파일 수, $arr['size'] <- 총 용량 수
                $stat = dirsize('/home/samba/userfile/'.$id);

                echo "<h1>총 파일 용량</br>".attach($stat['size'])."</h1>";
            ?>
        </ul>
    </div>


    <div class="rightmenu">
      
      <nav class="storage">
        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
            <div id="drag_upload_file">
              <ul id="file_list"></ul>
              <?php
                $dir = "/home/samba/userfile/$id";
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
                    echo "<p>".$f."</p>";
                    echo "<br />";
                } 
              ?>
            </div>
        </div>
      </nav>


      <nav class="photo">
        <?php
          $dir = "/home/samba/userfile/$id";
          $handle  = opendir($dir);
          $files = array();
          while (false !== ($filename = readdir($handle))) {
              if($filename == "." || $filename == ".."){
                  continue;
              }
              if(is_file($dir . "/" . $filename)){
                $arr = explode(".",$filename);
                $filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
                if(in_array($arr[1], $filter)){
                  $files[] = $arr[0].".".$arr[1];
                }
              }
          }
          closedir($handle);
          sort($files);
          foreach ($files as $f) {
              echo "<p>".$f."</p>";
              echo "<br />";
          } 
        ?>
      </nav>


      <nav class="video">
        <?php
          $dir = "/home/samba/userfile/$id";
          $handle  = opendir($dir);
          $files = array();
          while (false !== ($filename = readdir($handle))) {
              if($filename == "." || $filename == ".."){
                  continue;
              }
              if(is_file($dir . "/" . $filename)){
                $arr = explode(".",$filename);
                $filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");
                if(in_array($arr[1], $filter)){
                  $files[] = $arr[0].".".$arr[1];
                }
              }
          }
          closedir($handle);
          sort($files);
          foreach ($files as $f) {
              echo "<p>".$f."</p>";
              echo "<br />";
          } 
        ?>
      </nav>


      <nav class="document">
        <?php
          $dir = "/home/samba/userfile/$id";
          $handle  = opendir($dir);
          $files = array();
          while (false !== ($filename = readdir($handle))) {
              if($filename == "." || $filename == ".."){
                  continue;
              }
              if(is_file($dir . "/" . $filename)){
                $arr = explode(".",$filename);
                $filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp", "PPT", "DOC", "XLS", "PPTX", "DOCX", "PDF", "AI", "PSD", "TXT", "HWP");
                if(in_array($arr[1], $filter)){
                  $files[] = $arr[0].".".$arr[1];
                }
              }
          }
          closedir($handle);
          sort($files);
          foreach ($files as $f) {
              echo "<p>".$f."</p>";
              echo "<br />";
          } 
        ?>
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
              echo "<p>".$f."</p>";
              echo "<br />";
          } 
        ?>
      </nav>      
    </div>

    <script type="text/javascript">

      function storage(){
        $('.trash').hide();
        $('.photo').hide();
        $('.video').hide();
        $('.document').hide();
        $('.storage').show();
      }

      function photo(){
        $('.trash').hide();
        $('.photo').show();
        $('.video').hide();
        $('.document').hide();
        $('.storage').hide();
      }

      function video(){
        $('.trash').hide();
        $('.photo').hide();
        $('.video').show();
        $('.document').hide();
        $('.storage').hide();
      }

      function document1(){
        $('.trash').hide();
        $('.photo').hide();
        $('.video').hide();
        $('.document').show();
        $('.storage').hide();
      }

      function trash(){
        $('.trash').show();
        $('.photo').hide();
        $('.video').hide();
        $('.document').hide();
        $('.storage').hide();
      }
    </script>
</body>
</html>
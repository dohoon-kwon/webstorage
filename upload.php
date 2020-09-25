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
  <link rel="stylesheet" href="css/upload.css?=ver1">
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
            <li class="top_menu_item" onclick="location.href='board.php'"><a>게시판 정보</a></li>
            <li class="top_menu_item" onclick="location.href='tool.php'"><a>홈페이지 관리</a></li>
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
    <div id="content">
      <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
          <div id="drag_upload_file">
            <p>Drop file here</p>
            <p>or</p>            
            <p><input type="button" value="Select File" onclick="file_explorer();"></p>
            <input type="file" id="selectfile" name="userfile">
          </div>
      </div>
  </div>

</body>
</html>
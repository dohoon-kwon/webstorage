<?php
    //세션
    session_start();
    $id = $_SESSION['id'];

    //URL링크
    if(!empty($_GET['link'])){
      $_SESSION['link'] = $_GET['link'];
    }
    else{
      $_SESSION['link'] = '';
    }
?>


<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>파일 저장소</title>

    <!--CSS-->
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/upload.css?ab">

    <!--드래그관련 자바스크립트-->
    <script src="//threedubmedia.com/inc/js/jquery-1.7.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drag-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drag.live-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drop-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drop.live-2.2.js"></script>

    <!--기본 자바스크립트-->
    <script type="text/javascript" src="js/upload.js?ver13"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>
    <!--상단 메뉴 바-->
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

    <!--좌측 DIV-->
    <div class="leftmenu">
        <ul>
            <?php
              include 'leftmenu.php';
            ?>

            <li class="progessbar"><progress value="<?=$sample?>" max="100"></progress></li>

            <li><h1>드라이브</h1></li>

            <li><a onclick="location.href='?type='">모든 파일</a></li>

            <li><a onclick="location.href='?type=photo'">사진</a></li>

            <li><a onclick="location.href='?type=video'">동영상</a></li>

            <li><a onclick="location.href='?type=document'">문서</a></li>

            <li><a onclick="location.href='?type=trash'">휴지통</a><a id="trash_empty" onclick="trash_clear()">비우기</a></li>
        </ul>
    </div>


    <!--우측 DIV-->
    <div class="rightmenu">

      <!--파일 제어 버튼-->
      <form class="searchform" method="POST" action="">
        <ul>
          <li><input type="text" placeholder="검색어" name="value"></li>
          <li><input type="submit" value="검색"></li>
        </ul>

        <ul>
          <li><input type="button" value="파일업로드"></li>
          <li><input type="button" onClick="popup_open();" value="새 폴더"></li>
        </ul>
      </form>


      <!--디렉토리 경로-->
      <?php
        include 'link.php';
      ?>
      

      <!--파일 리스트-->
      <nav class="storage">
        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
            <div id="drag_upload_file">
              <ul id="file_list">
                <?php
                  include 'filelist.php';
                ?>
              </ul>
            </div>
        </div>
      </nav>

      
      <!--사진 뷰어-->
      <ul class="imgview" id="imgview">
        <li><a onclick="img_hide()">닫기</a></li>
      </ul>

    </div>

    
    <!--우클릭 메뉴창-->
    <ul class="contextmenu">
      <li><a onclick="download_file()">다운로드</a></li>
      <li><a onclick="remove_file()">삭제</a></li>
      <li><a href="#">공유하기</a></li>
    </ul>

  </body>
</html>

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
    <link rel="stylesheet" href="css/main.css?ab2">
    <link rel="stylesheet" href="css/upload.css?cd8">

    <!--드래그관련 자바스크립트-->
    <script src="//threedubmedia.com/inc/js/jquery-1.7.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drag-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drag.live-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drop-2.2.js"></script>
    <script src="//threedubmedia.com/inc/js/jquery.event.drop.live-2.2.js"></script>

    <!--기본 자바스크립트-->
    <script type="text/javascript" src="js/upload.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>
    <!--상단 메뉴 바-->
    <nav>
        <ul>
            <li class="logo"><img src='img/home_logo.png' onclick="location.href='upload.php'"></img></li>
            <li class="nav_right_menu">
              <a class="logout" href="login.php">로그아웃</a>
              <img src='img/bell.png' id="bell_img" onclick="msg_view()"></img>
              <?php
                include 'msgcount.php';
              ?>

              <ul class="msgmenu">
                <?php
                  include 'msgmenu.php';
                ?>
              </ul>
            </li>
        </ul>
        <ul class="top_menu">
            <?php
              include "lib/topmenu.php";
            ?>
        </ul>

    </nav>

    <!--좌측 DIV-->
    <div class="leftmenu">
        <ul>
            <?php
              include 'lib/leftmenu.php';
            ?>

            <li class="drive_option"><h1>드라이브</h1></li>

            <li class="drive_option"><a onclick="location.href='upload.php'">모든 파일</a></li>

            <li class="drive_option"><a onclick="location.href='?type=photo'">사진</a></li>

            <li class="drive_option"><a onclick="location.href='?type=video'">동영상</a></li>

            <li class="drive_option"><a onclick="location.href='?type=document'">문서</a></li>

            <li class="drive_option"><a onclick="location.href='?type=trash'">휴지통</a><a id="trash_empty" onclick="trash_clear()">비우기</a></li>
        </ul>
    </div>


    <!--우측 DIV-->
    <div class="rightmenu">

      <!--파일 제어 버튼-->
      <form class="searchform" method="POST" action="./process.php?mode=filesearch">
        <ul>
          <input type="hidden" value="<?=$_GET['type']?>" name="typecode">
          <li><input type="text" placeholder="검색어" name="value"></li>
          <li><input type="submit" value="검색"></li>
        </ul>

        <ul>
          <?php
            include "lib/divmenu.php";
          ?>
        </ul>
        
      </form>

      
      <!--파일정렬-->
      <form method="POST" action="./process.php?mode=search_condition">
          <div class="search_condition">
            <ul>
              <li><a>파일 정렬 조건</a></li>

              <li>
                <input type="radio" name="sort_value" value="FILE_NAME" checked="checked"/><a>이름</a>
                <input type="radio" name="sort_value" value="FILE_SIZE"/><a>파일크기</a>
              </li>

              <li>
                <input type="radio" name="sort_way" value="DESC" checked="checked"/><a>내림차순</a>
                <input type="radio" name="sort_way" value="ASC"/><a>오름차순</a>
              </li>

              <li>
                <input type="submit" value="설정" class="search_condition_submit_btn">
                <input type="button" value="취소" onclick="sort_file_cancle()" class="search_condition_cancle_btn">
              </li>

              <input type="hidden" value="<?=$_GET['type']?>" name="type">
              <input type="hidden" value="<?=$_GET['value']?>" name="value">
            </ul>
          </div>
        </form>


      <!--디렉토리 경로-->
      <?php
        include 'lib/link.php';
      ?>
      

      <!--파일 리스트-->
      <nav class="storage">
        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
            <div id="drag_upload_file">
              <ul id="file_list">
                <?php
                  include 'lib/filelist.php';
                ?>
              </ul>
            </div>
        </div>
      </nav>

      
      <!--사진 뷰어-->
      <ul class="imgview" id="imgview">
        <li><a onclick="img_hide()">닫기</a></li>
      </ul>


      <!--폴더 생성-->
      <ul class="mkdirview">
        <form action="./process.php?mode=mkdir" method="POST" class="mkdir_from">
          <ul>
            <li class="mkdir_li_a"><a>폴더 명</a></li>
            <li><input type="text" id="dirname" name="dirname" required></li>
            <li><input type="submit" value="생성" class="mkdir_submit_btn"><input type="button" onclick="mkdir_cancle()" value="취소" class="mkdir_cancle_btn"></li>
          </ul>
        </form>
      </ul>
    </div>

    <!--로딩 화면-->
    <div class="loading_div">
      <img src='img/loading.gif' class="loading_img"></img>
    </div>

    
    <!--우클릭 메뉴창-->
    <ul class="contextmenu">
      <?php
        include 'lib/contextmenu.php';
      ?>
    </ul>

  </body>
</html>

<?php
    //세션
    session_start();
    $id = $_SESSION['id'];

    //URL링크
    if(!empty($_GET['f']))
    {
      $_SESSION['share_folder'] = $_GET['f'];
    }
    else
    {
      $_SESSION['share_folder'] = '';
    }

    //URL링크
    if(!empty($_GET['link']))
    {
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
    <link rel="stylesheet" href="css/upload.css">

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
            include 'lib_share/leftmenu.php';
          ?>

          <li><h1>드라이브</h1></li>
          
          <?php
            include "lib_share/share_list.php";
          ?>
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
          <?php
            include "lib_share/share_divmenu.php";
          ?>
        </ul>
      </form>


      <!--디렉토리 경로-->
      <?php
        include 'lib_share/share_link.php';
      ?>
      

      <!--파일 리스트-->
      <nav class="storage">
        <div id="drop_file_zone" ondrop="upload_share_file(event)" ondragover="return false">
            <div id="drag_upload_file">
              <ul id="file_list">
                <?php
                  include 'lib_share/share_filelist.php';
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
        <form action="./process.php?mode=share_mkdir" method="POST" class="mkdir_from">
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
      <li onclick="download_file()"><a>다운로드</a></li>
      <li onclick="remove_file()"><a>삭제</a></li>
    </ul>

  </body>
</html>

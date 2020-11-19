<?php
    session_start();

    $grade = $_SESSION['grade'];

    if($grade === 'admin')
    {
        echo "<li class='top_menu_item' onclick='location.href=\"upload.php\"'><a>파일 저장소</a></li>";
        echo "<li class='top_menu_item' onclick='location.href=\"share.php\"'><a>공유 저장소</a></li>";
        echo "<li class='top_menu_item' onclick='location.href=\"tool.php\"'><a>홈페이지 관리</a></li>";
    }
    else
    {
        echo "<li class='top_menu_item' onclick='location.href=\"upload.php\"'><a>파일 저장소</a></li>";
        echo "<li class='top_menu_item' onclick='location.href=\"share.php\"'><a>공유 저장소</a></li>";
    }
?>
<?php
    //세션
    session_start();
    $id = $_SESSION['id'];
    $pw = $_SESSION['pw'];
    $grade = $_SESSION['grade'];
    //기능제한
    if($grade === 'basic'){
        echo "<script type=\"text/javascript\">alert('사용할 수 없는 기능입니다!');</script>";
        echo("<script>location.replace('board.php?id={$id}&pw={$pw}&grade={$grade}');</script>");	
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시글 작성</title>
        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/board_write.css">
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
        <form action="./process.php?mode=insert" method="POST">
            <h4>제목</h4>
            <input type="text" name="title" class="title">
            <h4>본문</h4>
            <textarea name="description" id="" cols="230" rows="30"></textarea>
            <input type="submit" value="저장" class="sbmbtn"/>          
        </form>
    </body>
</html>
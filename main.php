<?php
    session_start();
    $id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>메인페이지</title>
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/main.css">
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
    <h5>경섭이가 해줄거야 난 경섭이를 믿어</h5>
</body>
</html>
<?php
$id = $_GET['id'];
$pw = $_GET['pw'];
$grade = $_GET['grade'];

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
                <li><a class="idinfo"><?=$_GET['id']?>님 환영합니다.</a></li>
                <li><a class="logout" href="login.php">로그아웃</a></li>
            </ul>
            <ul class="top_menu">
                <li class="top_menu_item" onclick="location.href='upload.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>'"><a>파일 저장소</a></li>
                <li class="top_menu_item" onclick="location.href='board.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>'"><a>게시판 정보</a></li>
                <li class="top_menu_item" onclick="location.href='tool.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>'"><a>홈페이지 관리</a></li>
            </ul>
        </nav>
        <form action="./process.php?mode=insert" method="POST">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="pw" value="<?=$pw?>" />
            <input type="hidden" name="grade" value="<?=$grade?>" />
            <h4>제목</h4>
            <input type="text" name="title" class="title">
            <h4>본문</h4>
            <textarea name="description" id="" cols="230" rows="30"></textarea>
            <input type="submit" value="저장" class="sbmbtn"/>          
        </form>
    </body>
</html>
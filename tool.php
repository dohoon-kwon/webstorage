<?php
$dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$stmt = $dbh->prepare('SELECT * FROM USERINFO');
$stmt->execute();
$list = $stmt->fetchAll();

$id = $_GET['id'];
$pw = $_GET['pw'];
$grade = $_GET['grade'];

if($grade !== 'admin'){
    echo "<script type=\"text/javascript\">alert('사용할 수 없는 기능입니다!');</script>";
    echo("<script>location.replace('main.php?id={$id}&pw={$pw}&grade={$grade}');</script>");	
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>홈페이지 관리</title>
        <link rel="stylesheet" href="default.css">
        <link rel="stylesheet" href="main.css">
        <style>
            .info h2{
                border: 1px solid cornflowerblue;
            }
            .btn{
                background-color: cornflowerblue;
                color: white;
                padding: 10px 30px;
                display: inline-block;
            }
            .btn:hover{
                background-color: turquoise;
            }
        </style>
    </head>
<body>
    <nav>
        <ul>
            <li><a class="idinfo"><?=$_GET['id']?>님 환영합니다.</a></li>
            <li><a class="logout" href="login.php">로그아웃</a></li>
        </ul>
        <ul class="top_menu">
            <li class="top_menu_item"><a href="main.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">홈페이지 정보</a></li>
            <li class="top_menu_item"><a href="upload.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">파일 저장소</a></li>
            <li class="top_menu_item"><a href="board.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">게시판 정보</a></li>
            <li class="top_menu_item"><a href="tool.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">홈페이지 관리</a></li>
        </ul>
    </nav>

    <nav class="info">
        <?php
            foreach($list as $row) {
                echo "<h2>[ 이름 ] : ".htmlspecialchars($row['name'])." [ ID ] : ".htmlspecialchars($row['id'])." [ PW ] : ".htmlspecialchars($row['pw'])." [ TEL ] : ".htmlspecialchars($row['tel'])." [ GRADE ] : ".htmlspecialchars($row['grade'])."</h2>";
                echo "<a class=\"btn\" href=\"change.php?id={$id}&pw={$pw}&grade={$grade}&cid={$row['id']}\">수정</a>";
            }
        ?>
    </nav>
</body>
</html>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$stmt = $dbh->prepare('SELECT * FROM BOARD_TOPIC');
$stmt->execute();
$list = $stmt->fetchAll();
if(!empty($_GET['topic_id'])) {
    $stmt = $dbh->prepare('SELECT * FROM BOARD_TOPIC WHERE topic_id = :topic_id');
    $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $topic_id = $_GET['topic_id'];
    $stmt->execute();
    $topic = $stmt->fetch();
}

$id = $_GET['id'];
$pw = $_GET['pw'];
$grade = $_GET['grade'];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판</title>
        <link rel="stylesheet" href="default.css">
        <link rel="stylesheet" href="main.css">
        <style>
            .btm_list{
                width: 50%;
                margin: 0% 25%;
                top: 0;
                padding: 0;
                list-style-type: none;
                display: grid;
            }

            .btm_list_item_title{
                text-align: center;
                text-decoration: none;
                color: cornflowerblue;
                font-size: 24px;
                font-weight: bold;
                border: 1px solid cornflowerblue;
                border-top: none;
            }
            .btm_list_item input[type="button"]{
                background: cornflowerblue;
                color: white;
                border: none;
                padding: 5px 20px;
                cursor: pointer;
                display: block;
                float: right;
            }

            .btm_list_item input[type="button"]:hover{
                background-color: turquoise;
            }

            .btm_list_item{
                text-align: center;
                text-decoration: none;
                color: black;
                font-size: 16px;
                border: 1px solid cornflowerblue;
                border-top: none;
                font-weight: bold;
            }

            .btm_list_item a:hover{
                color: turquoise;
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

        <nav>
            <ul class="btm_list">
                <li class="btm_list_item_title">게시글목록</li>
                <li class='btm_list_item'><input type="button" value="새로운 글 작성" onClick="location.href='board_write.php?id=<?=$id?>&pw=<?=$pw?>&grade=<?=$grade?>'"/></li>
                <?php
                    foreach($list as $row) {
                    echo "<li class='btm_list_item'><a href=\"board_read.php?topic_id={$row['topic_id']}&id={$id}&pw={$pw}&grade={$grade}\">".htmlspecialchars($row['title'])."</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </body>
</html>

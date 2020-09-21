<?php
$dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$stmt = $dbh->prepare('SELECT * FROM BOARD_TOPIC');
$stmt->execute();
$list = $stmt->fetchAll();

$cstmt = $dbh->prepare('SELECT * FROM BOARD_COMMENT WHERE boardnum = :boardnum');
$cstmt->bindParam(':boardnum', $boardnum, PDO::PARAM_INT);
$boardnum = $_GET['topic_id'];
$cstmt->execute();
$comment = $cstmt->fetchAll();

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
            .btm_menu{
                width: 100%;
                margin: 0;
                padding: 0;
                list-style-type: none;
                border: 1px solid black;
            }

            .btm_list_item_title{
                text-align: center;
                text-decoration: none;
                color: black;
                font-size: 24px;
                font-weight: bold;
            }

            .btm_list_item_name{
                text-align: center;
                text-decoration: none;
                color: black;
                font-size: 16px;
                font-weight: bold;
                border: 1px solid cornflowerblue;
                border-left: none;
                border-right: none;
                border-bottom: none;
            }

            .btm_list_item{
                text-decoration: none;
                height: 500px;
                border: 1px solid cornflowerblue;
                border-left: none;
                border-right: none;
            }

            .btm_list_item a{
                color: black;
                font-size: 16px;
            }

            .comment{
                display: flex;
            }
            .comment input[type='submit']{
                background: cornflowerblue;
                color: white;
                border: 0px;
                padding: 0px 1%;
                cursor: pointer;
            }
            .comment input[type='submit']:hover{
                background-color: turquoise;
            }

            .comment_board h1{
                border: 1px solid cornflowerblue;
                border-top: none;
            }
            .comment input[type="text"]{
                width: 100%;
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
            <li class="btm_list_item_title"><?=htmlspecialchars($topic['title'])?></li>
            <li class="btm_list_item_name">작성자 : <?=htmlspecialchars($topic['name'])?></li>
            <li class='btm_list_item'><a><?=htmlspecialchars($topic['description'])?></a></li>

            <li>
                <form  action="./process.php?mode=comment" method="POST">
                    <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
                    <input type="hidden" name="pw" id="pw" value="<?=$_GET['pw']?>">
                    <input type="hidden" name="grade" id="grade" value="<?=$_GET['grade']?>">
                    <input type="hidden" name="topic_id" id="topic_id" value="<?=$_GET['topic_id']?>">
                    <h1>댓글</h1>
                    <nav class="comment">
                        <input type="text" name="commenttext">
                        <input type="submit"  value="작성">
                    </nav>

                    <nav class="comment_board">
                    <?php
                        foreach($comment as $row) {
                            echo "<h1>".htmlspecialchars($row['name'])."</h1>";
                            echo "<h1>".htmlspecialchars($row['description'])."</h1>";
                        }
                    ?>
                    </nav>
                </form>
            </li>
        </ul>
    </nav>
</body>
</html>
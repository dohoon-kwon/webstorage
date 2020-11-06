<?php
    //정보불러오기
    require_once 'lib/dbinfo.php';
    
    if(!empty($_POST['option'])){
        $querysample = 'SELECT * FROM USERINFO WHERE '.$_POST['option'].'="'.$_POST['value'].'"';
        $stmt = $dbh->prepare($querysample);
        $stmt->execute();
        $list = $stmt->fetchAll();
    }
    else{
        $stmt = $dbh->prepare('SELECT * FROM USERINFO');
        $stmt->execute();
        $list = $stmt->fetchAll();
    }
    //세션
    session_start();
    $id = $_SESSION['id'];
    $pw = $_SESSION['pw'];
    $grade = $_SESSION['grade'];
    //기능제한
    if($grade !== 'admin'){
        echo "<script type=\"text/javascript\">alert('사용할 수 없는 기능입니다!');</script>";
        echo("<script>location.replace('upload.php');</script>");	
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>홈페이지 관리</title>
        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/tool.css?ver=1">
    </head>
    
    <body>
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

        <nav class="search"> 
            <form action="tool.php" method="POST">
                <input type="radio" id="name" name="option" value="name"><label>이름</label>
                <input type="radio" id="id" name="option" value="id"><label>ID</label>
                <input type="radio" id="tel" name="option" value="tel"><label>전화번호</label>
                <input type="radio" id="grade" name="option" value="grade"><label>등급</label>
                <input type="text" name="value" placeholder="검색어">
                <input type="submit" value="검색">
            </form>
        </nav>
        <?php
            foreach($list as $row) {
                echo "<nav class=\"info\"><h2>
                [ 이름 ] : ".htmlspecialchars($row['name']).
                " [ ID ] : ".htmlspecialchars($row['id']).
                " [ PW ] : ".htmlspecialchars($row['pw']).
                " [ 전화번호 ] : ".htmlspecialchars($row['tel']).
                " [ 등급 ] : ".htmlspecialchars($row['grade']).
                "<input type='button' onClick=location.href=\"change.php?cid={$row['id']}\" value='수정'>".
                "<input type='button' onClick=location.href=\"./process.php?mode=delete&cid={$row['id']}\" value='탈퇴'>".
                "</h2></nav>";
            }
            echo $option;
            echo $value;
        ?>
    </body>
</html>
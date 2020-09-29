<?php
    $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stmt = $dbh->prepare('SELECT * FROM USERINFO WHERE id=:id');
    $stmt->bindParam(':id', $cid);
    $cid = $_GET['cid'];
    $stmt->execute();
    $list = $stmt->fetch();

    //세션
    session_start();
    $id = $_SESSION['id'];
    $pw = $_SESSION['pw'];
    $grade = $_SESSION['grade'];
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>정보수정</title>
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/change.css">
</head>
<body>
    <nav>
        <ul>
            <li><a class="idinfo"><?=$_GET['id']?>님 환영합니다.</a></li>
            <li><a class="logout" href="login.php">로그아웃</a></li>
        </ul>
        <ul class="top_menu">
            <li class="top_menu_item" onclick="location.href='upload.php'"><a>파일 저장소</a></li>
            <li class="top_menu_item" onclick="location.href='share.php'"><a>공유 저장소</a></li>
            <li class="top_menu_item" onclick="location.href='tool.php'"><a>홈페이지 관리</a></li>
        </ul>
    </nav>

    <form action="./process.php?mode=change" method="POST" class="forminfo">
        <input type="hidden" name="cid" value="<?=$_GET['cid']?>">
        <h2>이름 : </h2>
        <input name="name" type="text" value="<?=$list['name']?>">
        <h2>ID : </h2>
        <input name="id" type="text" value="<?=$list['id']?>">
        <h2>PW : </h2>
        <input name="pw" type="text" value="<?=$list['pw']?>">
        <h2>TEL : </h2>
        <input name="tel" type="text" value="<?=$list['tel']?>">
        <h2>등급 : </h2>
        <input name="grade" type="text" value="<?=$list['grade']?>">
        <input type="submit" value="저장">
    </form>
    
</body>
</html>
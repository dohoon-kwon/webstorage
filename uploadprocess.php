<?php
    //세션
    session_start();
    $id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>파일 저장소</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/upload.css?ver=1">
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
    <?php
        ini_set("display_errors", "1");
        $uploaddir = "/home/samba/userfile/$id/";
        $uploadfile = $uploaddir.($_FILES['file']['name']);
        echo '<pre>';
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
        } else {
            print "파일 업로드 공격의 가능성이 있습니다!\n";
        }
        echo $uploaddir;
        echo '자세한 디버깅 정보입니다:';
        print_r($_FILES);
        print "</pre>";
    ?>
    </body>
</html>


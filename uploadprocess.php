<?php
    //세션
    session_start();
    $id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
</head>   
<body>
    <?php
    session_start();
    ini_set("display_errors", "1");
    $uploaddir = "/home/samba/userfile/".$id."/";
    $uploadfile = $uploaddir.($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
    } else {
        print "파일 업로드 공격의 가능성이 있습니다!\n";
    }
    ?>
</body>
</html>


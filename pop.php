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
</head>
<body>
    <?php
        echo "<img src=\"{$_GET['file']}\"></img>"
    ?>
</body>
</html>

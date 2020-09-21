<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>파일 저장소</title>
<link rel="stylesheet" href="default.css">
<link rel="stylesheet" href="main.css">
<style>

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
    <form enctype="multipart/form-data" action="uploadprocess.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="99999999999999999" />
        <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
        <input name="userfile" type="file" />
        <input type="submit" value="업로드" />
    </form>
</body>
</html>
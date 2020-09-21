<?php
$id = $_GET['id'];
$pw = $_GET['pw'];
$grade = $_GET['grade'];

if($grade === 'basic'){
    echo "<script type=\"text/javascript\">alert('사용할 수 없는 기능입니다!');</script>";
    echo("<script>location.replace('board.php?id={$id}&pw={$pw}&grade={$grade}');</script>");	
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
	<title>게시글 작성</title>
	<link rel="stylesheet" href="default.css">
	<style type="text/css">
        body{
            margin: 0;
        }
	</style>
    </head>
   
    <body id="body">
	<form action="./process.php?mode=insert" method="POST">
	    <input type="hidden" name="id" value="<?=$id?>" />
	    <input type="hidden" name="pw" value="<?=$pw?>" />
	    <input type="hidden" name="grade" value="<?=$grade?>" />
            <p>제목 : <input type="text" name="title"></p>
            <p>본문 : <textarea name="description" id="" cols="230" rows="30"></textarea></p>
            <p><input type="submit" value="저장"/></p>            
        </form>
	</body>
</html>


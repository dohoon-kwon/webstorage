<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
	<title>회원가입</title>
	<link rel="stylesheet" href="default.css">
    </head>   
    <body>
        <form action="./process.php?mode=create" method="POST">
            <p>ID : <input type="text" name="id"></p>
            <p>PW : <input type="password" name="pw"></p>
            <p>전화번호 : <input type="text" name="tel"></p>
            <p>이름 : <input type="text" name="name"></p>
            <p><input type="submit" value="가입"/></p>            
        </form>
    </body>
</html>
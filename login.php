<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>로그인</title>
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<form action="./process.php?mode=login" method="POST">
        <div class="login">
            <h2>CLOUD SORAGE</h2>
            <ul class="top">
            <li><label for="txt1">아이디</label><input type="text" name="id" id="id" placeholder="ID" required></li>
            <li><label for="txt2">비밀번호</label><input type="password" name="pw" id="pw" placeholder="PASSWORD" required></li>
            <li class="btn"><input type="submit" value="로그인">
            </ul>
            <ul class="btm">
            <li>회원가입은 이곳에서<a href="makeaccount.html">회원가입</a></li>
            </ul>
        </div>
	</form>

</body>
</html>
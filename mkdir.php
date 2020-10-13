<html>
  <head>
    <meta charset="utf-8">
    <title>새 폴더</title>
    <link rel="stylesheet" href="css/mkdir.css">
    <link rel="stylesheet" href="css/default.css">
  </head>
  <body>
      <!--디렉토리 생성-->
      <div>
        <form action="./process.php?mode=mkdir" method="POST">
            <input type="text" id="dirname" name="dirname">
            <input type="submit" value="생성">
        </form>
      </div>
  </body>
</html>
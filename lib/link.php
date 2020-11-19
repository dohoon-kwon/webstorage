<?php
    //공유폴더 유저명 리턴하기
    function folder_list_check($file_name){
        $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $stmt = $dbh->prepare("SELECT * from DATAINFO WHERE FILE_NAME = :file_name");
        $stmt->bindParam(':file_name',$file_name);
        $stmt->execute();
        $slist = $stmt->fetch();

        return $slist['FILE_ORIGIN_NAME'];
    }

    //디렉토리 순서도
    if(!empty($_GET['link'])){
        $link = $_GET['link'];
        $arr = explode("/",$link);
        $dir = '';
        
        echo "<nav class=\"link\">";
        echo "<a onclick=\"location.href='upload.php'\">클라우드</a>";
        
        foreach ($arr as $d){
            $name = folder_list_check($d);
            $dir = $dir.$d;

            echo "<h2>&nbsp;>&nbsp;</h2>";
            echo "<a onclick=\"location.href='upload.php?link=$dir'\">$name</a>";
            $dir = $dir.'/';
        }

        echo "</nav>";
    }
?>
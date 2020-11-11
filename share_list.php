<?php
    session_start();
    $id = $_SESSION['id'];

    $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stmt = $dbh->prepare("SELECT * from SHAREINFO");
    $stmt->execute();
    $slist = $stmt->fetchAll();

    foreach($slist as $listdata)
    {
        if(strpos($listdata['SHARE_USERS'], $id) !== false)
        {
            $newstmt = $dbh->prepare("SELECT * from SHAREINFO WHERE SHARE_CODE = :scode");
            $newstmt->bindParam(':scode',$scode);
            $scode = $listdata['SHARE_CODE'];
            $newstmt->execute();
            $slist = $newstmt->fetch();

            //echo "<li><a>".$slist["SHARE_NAME"]."</a></li>";
            //echo "<li><a onclick='location.href=\"?type=$slist['SHARE_CODE']\"'>".$slist['SHARE_NAME']</a></li>"

            $link = "location.href='?f=".$slist["SHARE_CODE"]."'";
            
            echo "<li><a onclick=".$link.">".$slist["SHARE_NAME"]."</a></li>";
        }
    }
?>
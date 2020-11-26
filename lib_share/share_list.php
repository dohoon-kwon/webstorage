<?php
    require_once 'lib/dbinfo.php';
    
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

            $link = "location.href='?f=".$slist["SHARE_CODE"]."'";
            
            echo "<li class='sharelist_li'><a onclick=".$link.">".$slist["SHARE_NAME"]."</a></li>";
        }
    }
?>
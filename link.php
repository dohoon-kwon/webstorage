<?php
    if(!empty($_GET['link'])){
    $link = $_GET['link'];
    $arr = explode("/",$link);
    $dir = '';
    echo "<nav class=\"link\">";
    echo "<a onclick=\"location.href='upload.php'\">클라우드</a>";
    foreach ($arr as $d){
        $dir = $dir.$d;
        echo "<h2>&nbsp;>&nbsp;</h2>";
        echo "<a onclick=\"location.href='upload.php?link=$dir'\">$d</a>";
        $dir = $dir.'/';
    }
    echo "</nav>";
    }
?>
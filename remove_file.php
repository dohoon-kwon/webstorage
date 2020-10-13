<?php
    //파일삭제
    session_start();
    $id = $_SESSION['id'];
    $element = $_POST['element'];
    $link = $_SESSION['link'];
    
    rename("/home/samba/userfile/".$id."/".$link."/".$element, "/home/samba/userfile/".$id."trash/".$element);
?>
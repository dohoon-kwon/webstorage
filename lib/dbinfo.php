<?php
    $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    //세션
    session_start();
    $id = $_SESSION['id'];
    $link = $id.'/'.$_SESSION['link'];
?>
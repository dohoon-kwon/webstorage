<?php
    session_start();
    $count = $_SESSION['msg_count'];
    
    if($count !== 0)
    {
        echo "<h1 class='msgcount'>새로운 알림 $count</h1>";
    }
?>
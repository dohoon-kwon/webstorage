<?php
    $type = $_GET['type'];

    if($type !== 'trash')
    {
        echo "<li onclick='download_file()'><a>다운로드</a></li>";
        echo "<li onclick='remove_file()'><a>삭제</a></li>";
    }
    else
    {
        echo "<li><a>복원</a></li>";
        echo "<li><a>영구삭제</a></li>";
    }
    
?>
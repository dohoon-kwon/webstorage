<?php
    //PDF파일 뷰어
    session_start();
    $id = $_SESSION['id'];
    $name = $_GET['name'];
    $link = $_GET['link'];
    
    if(($link) === ''){
        $file = 'userfile/'.$id.'/'.$name;
    }

    else{
        $file = 'userfile/'.$id.'/'.$link.'/'.$name;
    }

    $filename = $name;

    header('Content-type: application/pdf; charset=UTF-8;');
    header('Content-Disposition: inline; filename="'.$filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);
?>
  
<iframe src="./viewer.php" style="width:718px; height:900px;" frameborder="0"></iframe>
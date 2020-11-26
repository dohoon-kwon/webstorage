<?php
    $folder = $_GET['f'];

    if($folder === '' || $folder == null)
    {
        echo "<li><input type='button' onClick='share_file();' value='새 공유'></li>";
    }
    else
    {
        echo "<li><input type='button' onClick='mkdir_open();' value='새 폴더'></li>";
    }
?>
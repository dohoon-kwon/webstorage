<?php
    $type = $_GET['type'];

    if($type === '' || $type == null)
    {
        echo "<li><input type='button' onClick='mkdir_open();' value='새 폴더'></li>";
        echo "<li><input type='button' onClick='sort_file()' value='정렬'></li>";
    }
    else if($type === 'trash')
    {
        echo "<li><input type='button' onClick='trash_clear();' value='비우기'></li>";
    }
    else
    {
        echo "<li><input type='button' onClick='sort_file()' value='정렬'></li>";
    }
?>
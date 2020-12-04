<?php
  $fname = $_GET['f'];

  if($fname === '' || $fname === null)
  {
    echo '<ul class="share_main_ul">';
    echo '<li><img src="img/home_logo.png"></img></li>';
    echo "<li><input type='button' onClick='share_file();' value='새 공유'></li>";
    echo '</ul>';
  }
  else
  {
    echo '<form class="searchform" method="POST" action="./process.php?mode=filesearch">';
    echo '<ul>';
    echo '<input type="hidden" value="share" name="typecode">';
    echo '<input type="hidden" value="'.$fname.'" name="folder">';
    echo '<li><input type="text" placeholder="검색어" name="value"></li>';
    echo '<li><input type="submit" value="검색"></li>';
    echo '</ul><ul>';
    echo "<li><input type='button' onClick='mkdir_open();' value='새 폴더'></li>";
    echo "<li><input type='button' onClick='member_invite();' value='초대하기'></li>";
    echo '</ul></form>';
  }
?>
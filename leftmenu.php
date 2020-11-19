<?php
    session_start();

    // 폴더 전체용량
    function dirsize($dir){
        static $size;
        $fp = opendir($dir);

        while(false !== ($entry = readdir($fp))){
            if(($entry != ".") && ($entry != "..")){
                if(is_dir($dir.'/'.$entry)){
                    clearstatcache();
                    dirsize($dir.'/'.$entry);
                } 
                
                else if(is_file($dir.'/'.$entry)){
                    $size += filesize($dir.'/'.$entry);
                    clearstatcache();
                }
            }
        }
        closedir($fp);

        $stat = array(
            'size' => $size,
        );

        return $stat;
    }

    function attach($size) {
        if($size < 1024){
            return number_format($size*1.024).'B';
        } 
        
        else if(($size > 1024) && ($size < 1024000)){
            return number_format($size*0.001024).'KB';
        } 
        
        else if($size > 1024000){
            return number_format($size*0.000001024,2).'MB';
        }

        return 0;
    }
    
    $stat = dirsize('/home/samba/userfile/'.$id);
    $result = 307200000 - $stat['size'];

    echo "<li><h1 class='idinfo'>".$_SESSION['id']."님 환영합니다.</h1></li>";
    echo "<li><a>마이페이지</a></li>";
    echo "<li class='userinfo'><h1>[ 총 파일 용량 ]</br>".attach($stat['size'])."</h1></li>";
?>
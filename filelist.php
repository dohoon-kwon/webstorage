<?php
    session_start();
    $id=$_SESSION['id'];

    if($_GET['type'] !== 'trash'){
        $dir = "/home/samba/userfile/$id";
        $handle  = opendir($dir);
        $files = array();
        $dirs=array();

        while (false !== ($filename = readdir($handle))) {
            if($filename == "." || $filename == ".."){
                continue;
            }
            if(is_file($dir . "/" . $filename)){
                $files['file'][] = $filename;
                $arr = explode(".",$filename);
                $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
                $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp");
                $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");

                if(in_array($arr[1], $img_filter)){
                    $files['img'][] = $arr[0].".".$arr[1];
                }else if(in_array($arr[1], $doc_filter)){
                    $files['doc'][] = $arr[0].".".$arr[1];
                }else if(in_array($arr[1], $video_filter)){
                  $files['video'][] = $arr[0].".".$arr[1];
                }

            }else
            {
                $dirs[] = $filename;
            }
        }

        closedir($handle);
        sort($files['doc']);
        sort($files['video']);
        sort($files['img']);
        switch($_GET['type']){
            case '':   
                foreach ($dirs as $f) {
                    echo "<li class='dir'><img src='img/directory.png'></img><p>".$f."</p></li>";
                } 
                foreach ($files['doc'] as $f) {   
                    echo "<li class='doc'><img src='img/directory.png'></img><p>".$f."</p></li>";
                    }
                foreach ($files['video'] as $f) {   
                    echo "<li class='video'><img src='img/directory.png'></img><p>".$f."</p></li>";
                    } 
                foreach ($files['img'] as $f) {   
                    echo "<li class='img'><img src='img/directory.png'></img><p>".$f."</p></li>";
                    } 
              break;

            case 'photo':
                foreach ($files['img'] as $f) {   
                    echo "<li class='img'><img src='img/directory.png'></img><p>".$f."</p></li>";
              } 
              break;

            case 'video':
                foreach ($files['video'] as $f) {   
                    echo "<li class='video'><img src='img/directory.png'></img><p>".$f."</p></li>";
                  } 
              break;

            case 'document':
              foreach ($files['doc'] as $f) {   
                echo "<li class='doc'><img src='img/directory.png'></img><p>".$f."</p></li>";
                }
            break;
          }
      }

      else{
        // 폴더명 지정
        $dir = "/home/samba/userfile/$id"."trash";
        // 핸들 획득
        $handle  = opendir($dir);
        $files = array();

        while (false !== ($filename = readdir($handle))) {
            if($filename == "." || $filename == ".."){
                continue;
            }
            if(is_file($dir . "/" . $filename)){
                $files['file'][] = $filename;
                $arr = explode(".",$filename);
                $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
                $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp");
                $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");

                if(in_array($arr[1], $img_filter)){
                    $files['img'][] = $arr[0].".".$arr[1];
                }else if(in_array($arr[1], $doc_filter)){
                    $files['doc'][] = $arr[0].".".$arr[1];
                }else if(in_array($arr[1], $video_filter)){
                  $files['video'][] = $arr[0].".".$arr[1];
                }

            }
        }
        // 파일명을 출력한다.
        foreach ($files['doc'] as $f) {   
            echo "<li class='doc'><img src='img/directory.png'></img><p>".$f."</p></li>";
            }
        foreach ($files['video'] as $f) {   
            echo "<li class='video'><img src='img/directory.png'></img><p>".$f."</p></li>";
            } 
        foreach ($files['img'] as $f) {   
            echo "<li class='img'><img src='img/directory.png'></img><p>".$f."</p></li>";
            } 
      }





?>
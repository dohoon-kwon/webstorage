<?php
    session_start();
    $id=$_SESSION['id'];
    $link = $_SESSION['link'];
    $folder_name = $_GET['f'];


    $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
    $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp");
    $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");


    $files = array();
    $dirs = array();


    function Search_file($dir, $type, $img_filter, $doc_filter, $video_filter, $id, $link)
    {
        $file_list = scandir($dir);
        $link = str_replace("/home/samba/",'',$dir);
        $doc_link = str_replace('userfile/'.$id,'',$link);
        $PDF_filter = array("pdf", "PDF");


        unset($file_list[array_search('.', $file_list, true)]);
        unset($file_list[array_search('..', $file_list, true)]);
        
    
        if (count($file_list) < 1)
            return;
        

        foreach($file_list as $file_item){
            if($type === 'photo')
            {
                if(in_array(pathinfo($file_item, PATHINFO_EXTENSION), $img_filter))
                {
                    echo "<li class='img drop' onclick=\"img_open('$link/$file_item')\" id='$file_item'><img src='userfile/thumbnail/$id/$file_item'></img><p>$file_item</p></li>";
                }
            }
            else if($type === 'video')
            {
                if(in_array(pathinfo($file_item, PATHINFO_EXTENSION), $video_filter))
                {
                    echo "<li class='video drop' id='$file_item'><img src='userfile/thumbnail/$id/$file_item.jpg'></img><p>".$file_item."</p></li>";
                }
            }
            else if($type === 'doc')
            {
                if(in_array(pathinfo($file_item, PATHINFO_EXTENSION), $doc_filter))
                {
                    if(in_array(pathinfo($file_item, PATHINFO_EXTENSION), $PDF_filter))
                    {
                        echo "<li class='doc drop' onclick=\"location.href='pdfview.php?link=$doc_link&name=$file_item'\" id='$file_item'><img src='img/doc_pdf.png'></img><p>".$file_item."</p></li>";
                    }
                    else
                    {
                        echo "<li class='doc drop' id='$file_item'><img src='img/doc_word.png'></img><p>".$file_item."</p></li>";
                    }
                }
            }
            
            if(is_dir($dir.'/'.$file_item))
            {
                Search_file($dir.'/'.$file_item, $type, $img_filter, $doc_filter, $video_filter, $id, $link);
            }
        }
    }

    
    //저장소 창
    if(!empty($_GET['f']))
    {
        if(!empty($_GET['link']))
        {
            $dir = "/home/samba/userfile/share/$folder_name/$link";
        }

        else
        {
            $dir = "/home/samba/userfile/share/$folder_name";
        }


        switch($_GET['type'])
        {
            case '':
                $handle  = opendir($dir);

                while (false !== ($filename = readdir($handle)))
                {
                    if($filename == "." || $filename == "..")
                    {
                        continue;
                    }
                    
                    if(is_file($dir . "/" . $filename))
                    {
                        if(in_array(pathinfo($filename, PATHINFO_EXTENSION), $img_filter))
                        {
                            $files['img'][] = $filename;
                        }
                        else if(in_array(pathinfo($filename, PATHINFO_EXTENSION), $doc_filter))
                        {
                            $files['doc'][] = $filename;
                        }
                        else if(in_array(pathinfo($filename, PATHINFO_EXTENSION), $video_filter))
                        {
                          $files['video'][] = $filename;
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


                foreach ($dirs as $f)
                {
                    if($link === ''){
                        echo "<li class='dir drop' onclick=\"location.href='?link=$f'\" id='$f'><img src='img/directory.png'></img><p>".$f."</p></li>";
                    }
                    else{
                        echo "<li class='dir drop' onclick=\"location.href='?link=$link/$f'\" id='$f'><img src='img/directory.png'></img><p>".$f."</p></li>";
                    }
                }

                foreach ($files['doc'] as $f)
                {
                    if($link === ''){
                        echo "<li class='doc drop' onclick=\"location.href='pdfview.php?link=&name=$f'\" id='$f'><img src='img/doc_word.png'></img><p>".$f."</p></li>";
                    }
                    else{
                        echo "<li class='doc drop' onclick=\"location.href='pdfview.php?link=$link&name=$f'\" id='$f'><img src='img/doc_word.png'></img><p>".$f."</p></li>";
                    }
                }

                foreach ($files['video'] as $f)
                {   
                    echo "<li class='video drop' id='$f'><img src='userfile/thumbnail/$id/$f.jpg'></img><p>".$f."</p></li>";
                } 

                foreach ($files['img'] as $f)
                {   
                    if($link === ''){
                        echo "<li class='img drop' onclick=\"img_open('userfile/$id/$f')\" id='$f'><img src='userfile/thumbnail/$id/$f'></img><p>".$f."</p></li>";
                    }
                    else{
                        echo "<li class='img drop' onclick=\"img_open('userfile/$id/$link/$f')\" id='$f'><img src='userfile/thumbnail/$id/$f'></img><p>".$f."</p></li>";
                    }
                } 

                break;


            case 'photo':
                Search_file($dir, 'photo', $img_filter, $doc_filter, $video_filter, $id, $link);
                break;


            case 'video':
                Search_file($dir, 'video', $img_filter, $doc_filter, $video_filter, $id, $link);
                break;


            case 'document':
                Search_file($dir, 'doc', $img_filter, $doc_filter, $video_filter, $id, $link);
                break;
          }
      }

      
    //휴지통인 경우
    else
    {
        echo "<h1>공유폴더</h1>";
    }
?>
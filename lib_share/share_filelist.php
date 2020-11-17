<?php
    require_once 'lib_share/share_dbinfo.php';

    $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
    $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp","xlsx");
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
                    echo "<li class='video drop' id='$file_item'><img src='userfile/thumbnail/$id/$file_item'></img><p>".$file_item."</p></li>";
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
        $stmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from DATAINFO WHERE FILE_USER_ID = :id and FILE_PATH = :link ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':link',$path);
        $stmt->execute();
        while ($row = $stmt->fetch()){
            if (in_array($row['FILE_EXTENSION'],$video_filter))
            {
                echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
            }
            else if(in_array($row['FILE_EXTENSION'],$img_filter))
            {
                echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
               // echo "<li class='img drop' onclick=\"img_open('$link/$file_item')\" id='$file_item'><img src='userfile/thumbnail/$id/$file_item'></img><p>$file_item</p></li>";
            }
            else if(in_array($row['FILE_EXTENSION'],$doc_filter))
            {
                if($row['FILE_EXTENSION']=='pdf')
                {
                    //echo "<li class='doc drop' onclick=\"location.href='pdfview.php?link=$doc_link&name=$file_item'\" id='$file_item'><img src='img/doc_pdf.png'></img><p>".$file_item."</p></li>";
                }
                else
                {
                    echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
            }
            else if ($row['FILE_EXTENSION']=='dir')
            {
                if($_SESSION['link'] === ''){
                    echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?link=".$row['FILE_ORIGIN_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else{
                    echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?link=".$_SESSION['link']."/".$row['FILE_ORIGIN_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                
            }
        }
    }

    //메인화면인 경우
    else
    {
        echo "<h1>공유폴더</h1>";
    }
?>
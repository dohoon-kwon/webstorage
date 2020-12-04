<?php
    if(!empty($_GET['f']))
    {
        echo '<nav class="storage">';
        echo '<div id="drop_file_zone" ondrop="upload_share_file(event)" ondragover="return false">';
        echo'<div id="drag_upload_file"><ul id="file_list">';
        include_once 'lib_share/share_dbinfo.php';
        $share_folder_link = $_SESSION['share_folder'];
        $link = $_SESSION['link'];

        $value = $_GET['value'];
        $search = '%'.$_GET['value'].'%';
        $fname = '%'.$_GET['f'].'%';

        if($link === '' || $link == null)
        {
            $path = "share/".$_SESSION['share_folder'];
        }
        else
        {
            $path = "share/".$_SESSION['share_folder'].'/'.$link;
        }

        $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
        $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp","xlsx");
        $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");


        if($value === '' || $value === null)
        {
            //저장소 창
            $stmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from DATAINFO WHERE FILE_PATH = :link ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
            $stmt->bindParam(':link',$path);
            $stmt->execute();

            while ($row = $stmt->fetch()){
                if (in_array($row['FILE_EXTENSION'],$video_filter))
                {
                    echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if(in_array($row['FILE_EXTENSION'],$img_filter))
                {
                    echo "<li class='img drop' onclick=\"img_open('userfile/".$path."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                {
                    echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if ($row['FILE_EXTENSION']=='dir')
                {
                    if($link === ''){
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?f=".$share_folder_link."&link=".$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else{
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?f=".$share_folder_link."&link=".$link.'/'.$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    
                }
            }
        }

        //검색하는 경우
        else
        {
            //저장소 창
            $stmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from DATAINFO WHERE FILE_PATH LIKE :fname and FILE_ORIGIN_NAME LIKE :search ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
            $stmt->bindParam(':fname',$fname);
            $stmt->bindParam(':search',$search);
            $stmt->execute();

            while ($row = $stmt->fetch()){
                if (in_array($row['FILE_EXTENSION'],$video_filter))
                {
                    echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if(in_array($row['FILE_EXTENSION'],$img_filter))
                {
                    echo "<li class='img drop' onclick=\"img_open('userfile/".$path."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                {
                    echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                }
                else if ($row['FILE_EXTENSION']=='dir')
                {
                    if($link === ''){
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?f=".$share_folder_link."&link=".$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else{
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?f=".$share_folder_link."&link=".$link.'/'.$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    
                }
            }
        }
        

        echo '</ul></div></div></nav>';
    }
?>
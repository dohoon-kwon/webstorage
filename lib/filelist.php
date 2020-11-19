<?php
    require_once 'lib/dbinfo.php';
    $link = $id.'/'.$_SESSION['link'];
    $search_value = $_GET['value'];


    //필터
    $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
    $doc_filter = array("ppt", "doc", "xls", "pptx", "docx", "pdf", "ai","psd", "txt", "hwp","xlsx");
    $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");

    $files = array();
    $dirs = array();


    if($search_value === '' || $search_value == null)
    {
        //쿼리
        $filestmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH,FILE_PATH from DATAINFO WHERE FILE_USER_ID = :id ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
        $filestmt->bindParam(':id',$id);
        $filestmt->execute();

        switch($_GET['type'])
        {
            case '':
                $stmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from DATAINFO WHERE FILE_USER_ID = :id and FILE_PATH = :link ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
                $stmt->bindParam(':id',$id);
                $stmt->bindParam(':link',$link);
                $stmt->execute();

                while ($row = $stmt->fetch())
                {
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if ($row['FILE_EXTENSION']=='dir')
                    {
                        if($_SESSION['link'] === ''){
                            echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?link=".$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                        }
                        else{
                            echo "<li class='dir drop' id='".$row['FILE_NAME']."' onclick=\"location.href='?link=".$_SESSION['link']."/".$row['FILE_NAME']."'\"><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                        }
                    }
                }
            break;


            case 'photo':
                while ($row = $filestmt->fetch()){
                    if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        //echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                        if($row['FILE_PATH'] === $id.'/')
                        {
                            echo "<li class='img drop' onclick=\"img_open('userfile/".$row['FILE_PATH'].$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                        }
                        else
                        {
                            echo "<li class='img drop' onclick=\"img_open('userfile/".$row['FILE_PATH']."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                        }
                    }
                }
            break;


            case 'video':
                while ($row = $filestmt->fetch()){
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'document':
                while ($row = $filestmt->fetch()){
                    if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'trash':
                $filestmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from TRASHINFO WHERE FILE_USER_ID = :id ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
                $filestmt->bindParam(':id',$id);
                $filestmt->execute();

                while ($row = $filestmt->fetch())
                {
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if ($row['FILE_EXTENSION']=='dir')
                    {
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."'><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;
        }
    }
    else
    {
        //검색하는 경우
        //쿼리
        $filestmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from DATAINFO WHERE FILE_USER_ID = :id and FILE_ORIGIN_NAME LIKE :search ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
        $filestmt->bindParam(':id',$id);
        $filestmt->bindParam(':search', $search_result);
        $search_result = '%'.$search_value.'%';
        $filestmt->execute();

        switch($_GET['type'])
        {
            case '':
                while ($row = $filestmt->fetch())
                {
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'photo':
                while ($row = $filestmt->fetch()){
                    if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'video':
                while ($row = $filestmt->fetch()){
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'document':
                while ($row = $filestmt->fetch()){
                    if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;


            case 'trash':
                $filestmt = $dbh->prepare("SELECT FILE_NAME,FILE_ORIGIN_NAME,FILE_EXTENSION,FILE_THUM_PATH from TRASHINFO WHERE FILE_USER_ID = :id and FILE_ORIGIN_NAME LIKE :search ORDER BY FIELD(FILE_EXTENSION,'dir') DESC");
                $filestmt->bindParam(':id',$id);
                $filestmt->bindParam(':search', $search_result);
                $search_result = '%'.$search_value.'%';
                $filestmt->execute();

                while ($row = $filestmt->fetch())
                {
                    if (in_array($row['FILE_EXTENSION'],$video_filter))
                    {
                        echo "<li class='video drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$img_filter))
                    {
                        echo "<li class='img drop' onclick=\"img_open('userfile/".$link."/".$row['FILE_NAME']."')\" id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if(in_array($row['FILE_EXTENSION'],$doc_filter))
                    {
                        echo "<li class='doc drop' id='".$row['FILE_NAME']."'><img src='".$row['FILE_THUM_PATH']."'</img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                    else if ($row['FILE_EXTENSION']=='dir')
                    {
                        echo "<li class='dir drop' id='".$row['FILE_NAME']."'><img src='img/directory.png'></img><p>".$row['FILE_ORIGIN_NAME']."</p></li>";
                    }
                }
            break;
        }
    }
?>
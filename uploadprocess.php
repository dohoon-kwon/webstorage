<?php
    require_once 'lib/dbinfo.php';

    ini_set("display_errors", "1");
    $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
    $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");
   
   
    $name=$_FILES['file']['name'];
    $ext =pathinfo($name, PATHINFO_EXTENSION);
    $tmp_name=uniqid().".".$ext;
    $size=$_FILES['file']['size'];

    $uploaddir = "/home/samba/userfile/".$link."/";
    $uploadfile = $uploaddir.($tmp_name);
    $thumbdir="userfile/thumbnail/".$id."/". $tmp_name.".jpg";

    $stmt = $dbh->prepare("INSERT INTO DATAINFO VALUES (:tmp_name,:name,:ext,:size,:path,:id,:thumbdir) ");
    $stmt->bindParam(':tmp_name',$tmp_name);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':ext',$ext);
    $stmt->bindParam(':size',$size);
    $stmt->bindParam(':path',$link);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':thumbdir',$thumbdir);

   // for($i = 0; $i < count($_FILES['file']['name']); $i++){

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            //이미지 업로드할때
            if(in_array($ext,$img_filter))
            {
                $info_image=getimagesize($uploadfile); 
                switch($info_image['mime']){
                    case "image/gif":
                        $new_image=imagecreatefromgif($uploadfile);
                        break;

                    case "image/jpg":
                    case "image/jpeg":
                        $new_image=imagecreatefromjpeg($uploadfile);
                        break;
                    
                    case "image/png":
                        $new_image=imagecreatefrompng($uploadfile);
                        break;

                    default:
                        $new_image=imagecreatefromjpeg($uploadfile);
                        break;
                }

                $width=$info_image[0];
                $height=$info_image[1];

                if($new_image){
                    
                    $canvas=imagecreatetruecolor(200,200);
                    
                    if($width>$height)
                    {
                        imagecopyresampled($canvas,$new_image,0,0,$width*0.1,$height*0.05,200,200,$width*0.8,$height*0.8);
                    }
                    else{
                        imagecopyresampled($canvas,$new_image,0,0,$width*0.05,$height*0.1,200,200,$width*0.8,$height*0.8);
                    }
                    imagegif($canvas,$thumbdir);
                }
            }
            //비디오 업로드할때
            else if(in_array($ext,$video_filter))
            {
                echo exec("ffmpeg -i $uploadfile -an -ss 00:00:03 -an -r 2 -vframes 1 -y $thumbdir");
                $info_image=getimagesize($thumbdir);
                $new_image=imagecreatefromjpeg($thumbdir);
                $bg = imagecreatefrompng("img/playbutton.png");

                if($new_image){
                    $canvas=imagecreatetruecolor(400,400);
                    imagecopyresampled($canvas, $new_image,0,0,0,0,400,400,$info_image[0],$info_image[1]);
                    imagecopyresampled($canvas,  $bg,125,125,0,0,150,150,512,512);
                    imagegif($canvas,$thumbdir);
                 }
            }
            else
            {   
                switch($ext)
                {
                    case 'pptx':
                    case 'ppt' : $thumbdir ='img/doc_ppt.png'; break;

                    case 'docx':
                    case 'doc' : $thumbdir ='img/doc_word.png'; break;

                    case 'txt' : $thumbdir ='img/doc_txt.png'; break;
                    case 'hwp' : $thumbdir ='img/doc_hwp.png'; break;
                    
                    case 'xlsx' : 
                    case 'xls' : $thumbdir ='img/doc_xls.png'; break;

                    case 'pdf' : $thumbdir ='img/doc_pdf.png'; break;
                }
            }

            if($stmt->execute())
            {
                echo "업로드 성공";
            }
            else
                echo $link;
        }
    
   // }  
?>


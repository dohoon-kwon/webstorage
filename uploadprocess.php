<?php
    //세션
    session_start();
    $id = $_SESSION['id'];

    ini_set("display_errors", "1");
    $img_filter = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
    $video_filter = array("ASF", "AVI", "BIK", "FLV", "MKV", "MOV", "MP4", "MPEG", "Ogg", "SKM", "TS", "WebM", "WMV", "asf", "avi", "bik", "flv", "mkv", "mov", "mp4", "mpeg", "ogg", "skm", "ts", "webm", "wmv");

    $uploaddir = "/home/samba/userfile/".$id."/";
    $uploadfile = $uploaddir.($_FILES['file']['name']);
    
    $thumbdir="userfile/thumbnail/".$id."/".$_FILES['file']['name'];

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        if(in_array(pathinfo($uploadfile, PATHINFO_EXTENSION),$img_filter))
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
                $canvas=imagecreatetruecolor(400,400);
                if($width>$height)
                {
                    imagecopyresampled($canvas,$new_image,0,0,$width*0.1,$height*0.05,400,400,$width*0.8,$height*0.8);
                }else{
                    imagecopyresampled($canvas,$new_image,0,0,$width*0.05,$height*0.1,400,400,$width*0.8,$height*0.8);
                }
                imagegif($canvas,$thumbdir);
           }
        }else if(in_array(pathinfo($uploadfile, PATHINFO_EXTENSION),$video_filter))
        {
            echo exec("ffmpeg -i $uploadfile -an -ss 00:00:03 -an -r 2 -vframes 1 -y $thumbdir.jpg");
            $info_image=getimagesize($thumbdir.".jpg");
            $new_image=imagecreatefromjpeg($thumbdir.".jpg");
            $bg = imagecreatefrompng("img/playbutton.png");

            if($new_image){
                $canvas=imagecreatetruecolor(400,400);
                imagecopyresampled($canvas, $new_image,0,0,0,0,400,400,$info_image[0],$info_image[1]);
                imagecopyresampled($canvas,  $bg,125,125,0,0,150,150,512,512);
                imagegif($canvas,$thumbdir.".jpg");
           }
        }
    }
    
    ?>


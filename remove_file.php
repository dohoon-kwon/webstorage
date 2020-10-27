<?php
    //파일삭제
    session_start();
    $id = $_SESSION['id'];
    $link = $_SESSION['link'];

    
    switch($_GET['mode'])
    {
        case "remove":
            $element = $_POST['element'];
            
            rename("/home/samba/userfile/".$id."/".$link."/".$element, "/home/samba/userfile/".$id."trash/".$element);

        break;

        case "clear":
            $dir = "/home/samba/userfile/".$id."trash";
            $thumnail_dir = "userfile/thumbnail/$id";

            $arr = array();
            $i = 0;

            //휴지통 비우기
            if (is_dir($dir))
            { 
              $objects = scandir($dir); 

              foreach ($objects as $object)
              { 
                if ($object != "." && $object != "..")
                { 
                  if (is_dir($dir."/".$object))
                  {
                    $arr[$i] = $object;
                    rmdir($dir."/".$object);
                    $i++;
                  }

                  else
                  {
                    $arr[$i] = $object;
                    unlink($dir."/".$object);
                    $i++;
                  }
                } 
              }
            }

            //썸네일 폴더 비우기
            if (is_dir($thumnail_dir))
            { 
              $thumnail_files = scandir($thumnail_dir); 
              foreach ($thumnail_files as $thumnail_file)
              { 
                if ($thumnail_file != "." && $thumnail_file != "..")
                { 
                  if (is_dir($thumnail_dir."/".$thumnail_file))
                  {
                    for($i = 0; $i < count($arr); $i++)
                    {
                      if($arr[$i] === $thumnail_file)
                      {
                        rmdir($thumnail_dir."/".$thumnail_file);
                      }
                    }
                  }
                  else
                  {
                    for($i = 0; $i < count($arr); $i++)
                    {
                      if($arr[$i] === $thumnail_file)
                      {
                        unlink($thumnail_dir."/".$thumnail_file);
                      }
                    }
                  }  
                } 
              }
            }
            
        break;
    }
    
?>
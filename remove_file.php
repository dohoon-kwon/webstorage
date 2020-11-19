<?php
    include_once 'lib/dbinfo.php';
    $link = $id.'/'.$_SESSION['link'];


    //폴더 하위 검색 및 삭제
    function dir_remove($dir_link,$id,$dbh)
    {
      $objects = scandir($dir_link); 
  
      foreach ($objects as $object)
      { 
        if ($object != "." && $object != "..")
        { 
          if (is_dir($dir_link."/".$object))
          {
            dir_remove($dir_link."/".$object, $id, $dbh);
            delete_filedata($object, $dbh);
            rename($dir_link.'/'.$object, "userfile/".$id."trash/".$object);
          }

          else
          {
            delete_filedata($object, $dbh);
            rename($dir_link.'/'.$object, "userfile/".$id."trash/".$object);
          }
        } 
      }
    }

    //데이터베이스 수정
    function delete_filedata($object, $dbh)
    {
      $trashfilestmt = $dbh->prepare("INSERT INTO TRASHINFO SELECT * FROM DATAINFO WHERE FILE_NAME = '".$object."'");
      $trashfilestmt->execute();
      $deletefilestmt = $dbh->prepare("DELETE FROM DATAINFO WHERE FILE_NAME ='".$object."'");
      $deletefilestmt->execute();
    }

    
    switch($_GET['mode'])
    {
        case "remove":
          $element = $_POST['element'];

          $dircheck = $dbh->prepare("SELECT * FROM DATAINFO WHERE FILE_NAME ='".$element."'");
          $dircheck->execute();
          $path = $dircheck->fetch();

          //폴더인지 검사
          if($path['FILE_EXTENSION'] === 'dir')
          {
            $trashstmt = $dbh->prepare("INSERT INTO TRASHINFO SELECT * FROM DATAINFO WHERE FILE_NAME = '".$element."'");
            $trashstmt->execute();
  
            $stmt = $dbh->prepare("DELETE FROM DATAINFO WHERE FILE_NAME ='".$element."'");
            $stmt->execute();

            //폴더 링크 구분
            if($path['FILE_PATH'] === $id.'/')
            {
              $rmdir = "userfile/".$path['FILE_PATH'].$path['FILE_NAME'];
            }
            else
            {
              $rmdir = "userfile/".$path['FILE_PATH'].'/'.$path['FILE_NAME'];
            }

            //폴더내용물 >> 휴지통
            dir_remove($rmdir, $id, $dbh);

            //삭제 누른 폴더 이동
            rename("userfile/".$link."/".$element, "userfile/".$id."trash/".$element);
          }

          //파일인 경우
          else
          {
            $trashstmt = $dbh->prepare("INSERT INTO TRASHINFO SELECT * FROM DATAINFO WHERE FILE_NAME = '".$element."'");
            $trashstmt->execute();
  
            $stmt = $dbh->prepare("DELETE FROM DATAINFO WHERE FILE_NAME ='".$element."'");
            $stmt->execute();
  
            rename("userfile/".$link."/".$element, "userfile/".$id."trash/".$element);
          }
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

          //썸네일폴더 파일 검색 삭제
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
                    if($arr[$i].'.jpg' === $thumnail_file)
                    {
                      rmdir($thumnail_dir."/".$thumnail_file);
                    }
                  }
                }
                else
                {
                  for($i = 0; $i < count($arr); $i++)
                  {
                    if($arr[$i].'.jpg' === $thumnail_file)
                    {
                      unlink($thumnail_dir."/".$thumnail_file);
                    }
                  }
                }  
              } 
            }
          }

          //데이터베이스 수정
          $stmt = $dbh->prepare("DELETE FROM TRASHINFO WHERE FILE_USER_ID ='".$id."'");
          $stmt->execute();

        break;

        case "zap":
          $element = $_POST['element'];

          $stmt = $dbh->prepare("DELETE FROM TRASHINFO WHERE FILE_NAME ='".$element."'");
          $stmt->execute();

          unlink("userfile/".$id."trash/".$element);
        break;
    }    
?>
<?php 
    require 'cla_directzip.php';
    require_once 'dbinfo.php';

    $files= json_decode($_GET['filelist'],true);
    $zip = new DirectZip();
    $zip->open($id.".zip");
  
    for($i = 0; $i < count($files); $i++)
    {
        $stmt = $dbh->prepare("SELECT FILE_ORIGIN_NAME,FILE_NAME,FILE_PATH from DATAINFO WHERE FILE_NAME = :file");
        $stmt->bindParam(':file',$files[$i]);
        $stmt->execute();
        $check = $stmt->fetch();
        $zip->addFile('userfile/'.$check['FILE_PATH'].'/'.$check['FILE_NAME'], $check['FILE_ORIGIN_NAME']);
    }
    $zip->close();
    
?>

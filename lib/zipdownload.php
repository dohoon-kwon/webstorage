<?php 
    require 'cla_directzip.php';
    require_once 'dbinfo.php';

    $files= json_decode($_GET['filelist'],true);
    $zip = new DirectZip();
    $zip->open($id.".zip");

    function Search_Dir($dir,$path)
    {
        global $dbh,$zip;
        $zip->addEmptyDir($path.$dir['FILE_ORIGIN_NAME']);

        $path=$path.$dir['FILE_ORIGIN_NAME']."/";

        $filepath=$dir['FILE_PATH']."/".$dir['FILE_NAME'];

        $stmt = $dbh ->prepare("SELECT FILE_ORIGIN_NAME,FILE_NAME,FILE_PATH,FILE_EXTENSION from DATAINFO WHERE FILE_PATH = :path");
        $stmt->bindParam(':path',$filepath);
        $stmt->execute();

        while($row=$stmt->fetch())
        {
            if($row['FILE_EXTENSION']=='dir')
            {
                Search_Dir($row,$path);
            }
            else
            {
                Zip_File($row,$path);
            }    

        }

    }   

    function Zip_File($file,$path)
    {
        global $zip;

        $zip->addFile('../userfile/'.$file['FILE_PATH'].'/'.$file['FILE_NAME'], $path.$file['FILE_ORIGIN_NAME']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    


    for($i = 0; $i < count($files); $i++)
    {
        $stmt = $dbh->prepare("SELECT FILE_ORIGIN_NAME,FILE_NAME,FILE_PATH,FILE_EXTENSION from DATAINFO WHERE FILE_NAME = :file");
        $stmt->bindParam(':file',$files[$i]);
        $stmt->execute();
        $check=$stmt->fetch();
        
        if($check['FILE_EXTENSION']=='dir')
        {
            Search_Dir($check,null);
        }
        else
        {
            Zip_File($check,null);
        }    
    }

    $zip->close();


    

    
?>


<?php
    require_once 'lib/dbinfo.php';
    $oldumask = umask(0);

    //새 알림 체크 함수
    function msgcount_check()
    {
        $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        //안 읽은 알림 수
        $_SESSION['msg_count'] = 0;

        $msg = $dbh->prepare("SELECT * from MSGINFO WHERE MSG_REC_USER = :rec_id and READ_BOOL = :bool");
        $msg->bindParam(':rec_id',$rec_id);
        $msg->bindParam(':bool',$bool);

        $rec_id = $_SESSION['id'];
        $bool = 0;

        $msg->execute();
        $msgcheck = $msg->fetchAll();

        foreach($msgcheck as $count){
            $_SESSION['msg_count'] += 1;
        }
    }

    //공유폴더 유저명 리턴하기
    function user_list_check($num){
        $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $stmt = $dbh->prepare("SELECT * from SHAREINFO WHERE SHARE_NUM=:num");
        $stmt->bindParam(':num',$num);
        $stmt->execute();
        $slist = $stmt->fetch();

        return $slist['SHARE_USERS'];
    }
    
    switch($_GET['mode']){

        case 'login':
            $stmt = $dbh->prepare("SELECT * from USERINFO WHERE id = :id and pw = :pw");
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':pw',$pw);
            $id = $_POST['id'];
            $pw = $_POST['pw'];
            $stmt->execute();
            $check = $stmt->fetch();
            if(empty($check)){
                echo "<script type=\"text/javascript\">alert('아이디 혹은 비밀번호를 확인해주세요!');</script>";
                echo("<script>location.replace('login.html');</script>");
                }
            else{
                $_SESSION['id']=$check['id'];
                $_SESSION['pw']=$check['pw'];
                $_SESSION['grade']=$check['grade'];

                msgcount_check();

                header("Location: upload.php"); 
            }
            break;


        case 'create':
            $idcheck = $dbh->prepare("SELECT * FROM USERINFO WHERE id=:id");
            $idcheck->bindParam(':id', $id);
        
            $id = $_POST['id'];
            $idcheck->execute();
        
            $idif = $idcheck->fetch();
            if(!empty($idif)){
                echo "<script type=\"text/javascript\">alert('존재하는 아이디입니다!');</script>";
                echo("<script>location.replace('makeaccount.php');</script>");
            }
            else{
                $stmt = $dbh->prepare("INSERT INTO USERINFO (id, pw, tel, name) VALUES (:id, :pw, :tel, :name)");
                $stmt->bindParam(':id',$id);
                $stmt->bindParam(':pw',$pw);
                $stmt->bindParam(':tel',$tel);
                $stmt->bindParam(':name',$name);
                $id = $_POST['id'];
                $pw = $_POST['pw'];
                $tel = (string)$_POST['tel1']."-".(string)$_POST['tel2']."-".(string)$_POST['tel3'];
                $name = $_POST['name'];
                $stmt->execute();
                mkdir("/home/samba/userfile/".$id , 0777, true);
                mkdir("/home/samba/userfile/".$id."trash" , 0777, true);
                mkdir("/home/samba/userfile/thumbnail/".$id , 0777, true);
                
                header("Location: login.html");
            }
            break;

            
        case 'change':
            $stmt = $dbh->prepare("UPDATE USERINFO SET id=:id, pw =:pw, tel=:tel, name=:name, grade=:grade WHERE id=:cid");
            $stmt->bindParam(':cid',$cid);
            $stmt->bindParam(':id',$oid);
            $stmt->bindParam(':pw',$cpw);
            $stmt->bindParam(':tel',$ctel);
            $stmt->bindParam(':name',$cname);
            $stmt->bindParam(':grade',$cgrade);

            $cid = $_POST['cid'];
            $oid = $_POST['id'];
            $cpw = $_POST['pw'];
            $ctel = $_POST['tel'];
            $cname = $_POST['name'];
            $cgrade = $_POST['grade'];

            $stmt->execute();
            header("Location: tool.php");
            break;


        case 'delete':
            $stmt = $dbh->prepare("DELETE FROM USERINFO WHERE id=:cid");
            $stmt->bindParam(':cid',$cid);
            $cid = $_GET['cid'];
            $stmt->execute();
            header("Location: tool.php");
            break;

        case 'mkdir':
            $dirname = $_POST['dirname'];
            $id = $_SESSION['id'];

            if($_SESSION['link']=="")
            {
                $link=$id;
            }
            else
            {
                $link = $id.'/'.$_SESSION['link'];
            }
            
            $tmp_name=uniqid();

            if($link === ''){
                mkdir("/home/samba/userfile/$id/$tmp_name", 0777, true);
            }
            else{
                mkdir("/home/samba/userfile/$link/$tmp_name", 0777, true);
            }
            $thumbdir ='img/directory.png';

            $stmt = $dbh->prepare("INSERT INTO DATAINFO VALUES (:tmp_name,:name,'dir',0,:path,:id,:thumbdir)");
            $stmt->bindParam(':tmp_name',$tmp_name);
            $stmt->bindParam(':name',$dirname);
            $stmt->bindParam(':path',$link);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':thumbdir',$thumbdir);
            $stmt->execute();
            
            if($_SESSION['link'] !== '' || $_SESSION['link'] !== null)
            {
                $header_link = 'upload.php?link='.$_SESSION['link'];
            }
            else
            {
                $header_link = 'upload.php';   
            }
            $thumbdir ='img/directory.png';

            $stmt = $dbh->prepare("INSERT INTO DATAINFO VALUES (:tmp_name,:name,'dir',0,:path,:id,:thumbdir)");
            $stmt->bindParam(':tmp_name',$tmp_name);
            $stmt->bindParam(':name',$dirname);
            $stmt->bindParam(':path',$link);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':thumbdir',$thumbdir);
            $stmt->execute();
            
            header("Location: $header_link");
            break;

        case 'share_mkdir':
            $dirname = $_POST['dirname'];
            $id = $_SESSION['id'];
            $link = $_SESSION['link'];
            $tmp_name = uniqid();

            if($link === '' || $link == null)
            {
                $path = "share/".$_SESSION['share_folder'];
                mkdir("/home/samba/userfile/$path/$tmp_name", 0777, true);
                $header_link = 'share.php?f='.$_SESSION['share_folder'];
            }
            else
            {
                $path = "share/".$_SESSION['share_folder']."/".$link;
                mkdir("/home/samba/userfile/$path/$link/$tmp_name", 0777, true);
                $header_link = 'share.php?f='.$_SESSION['share_folder'].'&link='.$_SESSION['link'];
            }

            $thumbdir ='img/directory.png';

            $stmt = $dbh->prepare("INSERT INTO DATAINFO VALUES (:tmp_name,:name,'dir',0,:path,:id,:thumbdir)");
            $stmt->bindParam(':tmp_name',$tmp_name);
            $stmt->bindParam(':name',$dirname);
            $stmt->bindParam(':path',$path);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':thumbdir',$thumbdir);
            $stmt->execute();
            
            header("Location: $header_link");
            break;

        case 'share_file':
            if($_POST['rev_user'] === $_SESSION['id'])
            {
                echo "<script>";
                echo "alert('본인에게 공유할 수 없습니다.');";
                echo "history.back()";
                echo "</script>";

                break;
            }

            $stmt = $dbh->prepare("INSERT INTO MSGINFO (MSG_TIME, MSG_REC_USER, MSG_SEND_USER, MSG_CONTENT, USER_LIST, READ_BOOL) VALUES (:msg_time, :rec_user, :send_user, :content, :user_list, :bool)");

            $stmt->bindParam(':msg_time',$msg_time);
            $stmt->bindParam(':rec_user',$rec_user);
            $stmt->bindParam(':send_user',$send_user);
            $stmt->bindParam(':content',$content);
            $stmt->bindParam(':user_list',$user_list);
            $stmt->bindParam(':bool',$bool);

            $msg_time = date("Y-m-d H:i:s", time());
            $rec_user = $_POST['rev_user'];
            $send_user = $_SESSION['id'];
            $content = $_POST['pro_name'];
            $user_list = $_SESSION['id'];
            $bool = 0;
            $stmt->execute();

            $slist = $dbh->prepare("INSERT INTO SHAREINFO (SHARE_CODE, SHARE_NAME, SHARE_USERS ) VALUES (:share_code, :share_name, :share_user)");

            $slist->bindParam(':share_code',$share_code);
            $slist->bindParam(':share_name',$share_name);
            $slist->bindParam(':share_user',$share_user);

            $share_code = uniqid();
            $share_name = $_POST['pro_name'];
            $share_user = $_SESSION['id'];
            $slist->execute();

            mkdir("/home/samba/userfile/share/$share_code", 0777, true);
            mkdir("/home/samba/userfile/thumbnail/$share_code" , 0777, true);

            msgcount_check();

            header("Location: share.php");

            break;

        case 'share_ok':
            $stmt = $dbh->prepare("UPDATE MSGINFO SET USER_LIST=:user_list, READ_BOOL=:bool WHERE MSG_NUM = :msg_num");

            $stmt->bindParam(':msg_num',$msg_num);
            $stmt->bindParam(':bool',$bool);
            $stmt->bindParam(':user_list',$user_list);

            $msg_num = $_POST['pk_num'];
            $bool = 1;
            $user_list = $_POST['user_list'].'#'.$_SESSION['id'];

            $stmt->execute();

            $user_list = user_list_check($_POST['pk_num']);

            $slist = $dbh->prepare("UPDATE SHAREINFO SET SHARE_USERS=:share_user WHERE SHARE_NUM=:share_num");

            $slist->bindParam(':share_num',$share_num);
            $slist->bindParam(':share_user',$share_user);

            $share_num = $_POST['pk_num'];
            $share_user = $user_list.'/'.$_SESSION['id'];

            $slist->execute();

            msgcount_check();

            break;

        case 'share_no':
            $stmt = $dbh->prepare("UPDATE MSGINFO SET READ_BOOL=:bool WHERE MSG_NUM = :msg_num");

            $stmt->bindParam(':msg_num',$msg_num);
            $stmt->bindParam(':bool',$bool);

            $msg_num = $_POST['pk_num'];
            $bool = 1;

            $stmt->execute();

            msgcount_check();

            break;

        case 'msg_all_clear':
            $stmt = $dbh->prepare("DELETE FROM MSGINFO WHERE MSG_REC_USER=:rec_user");

            $stmt->bindParam(':rec_user',$rec_user);
            $rec_user = $_SESSION['id'];

            $stmt->execute();

            $_SESSION['msg_count'] = 0;
            
            break;
            
        case 'msg_read_clear':
            $stmt = $dbh->prepare("DELETE FROM MSGINFO WHERE MSG_REC_USER=:rec_user and READ_BOOL = :bool");

            $stmt->bindParam(':rec_user',$rec_user);
            $stmt->bindParam(':bool',$bool);
            
            $rec_user = $_SESSION['id'];
            $bool = 1;

            $stmt->execute();
                
            break;

        case 'restore':
            $element = $_POST['element'];

            $restorestmt = $dbh->prepare("INSERT INTO DATAINFO SELECT * FROM TRASHINFO WHERE FILE_NAME = '".$element."'");
            $restorestmt->execute();

            $updatestmt = $dbh->prepare("UPDATE DATAINFO SET FILE_PATH=:path WHERE FILE_NAME = '".$element."'");
            $updatestmt->bindParam(':path', $path);
            $path = $id;
            $updatestmt->execute();
  
            $stmt = $dbh->prepare("DELETE FROM TRASHINFO WHERE FILE_NAME ='".$element."'");
            $stmt->execute();
  
            rename("userfile/".$id."trash/".$element, "userfile/".$id."/".$element);

            break;


        case 'filesearch':
            $type = $_POST['typecode'];
            $value = $_POST['value'];

            if($type === '' || $type == null)
            {
                $result = "upload.php?value=".$value;
            }
            else if($type === 'share')
            {
                $folder = $_POST['folder'];
                $result = "share.php?f=".$folder."&type=".$type."&value=".$value;
            }
            else
            {
                $result = "upload.php?type=".$type."&value=".$value;
            }
            
            header("Location: $result");

            break;

        case 'search_condition':
            $type = $_POST['type'];
            $value = $_POST['value'];
            $sort_value = $_POST['sort_value'];
            $sort_way = $_POST['sort_way'];
            $link = "upload.php?sort=".$sort_value."&way=".$sort_way;

            if($type !== null || $type !== '')
            {
                $link = $link."&type=".$type;

                if($value !== null || $value !== '')
                {
                    $link = $link."&value=".$value;
                }
            }
            else
            {
                if($value !== null || $value !== '')
                {
                    $link = $link."&value=".$value;
                }
            }

            header("Location: $link");

            break;

        case 'share_exit':
            $stmt = $dbh->prepare("SELECT * FROM SHAREINFO WHERE SHARE_CODE = :fname");

            $stmt->bindParam(':fname',$fname);
            $fname = $_POST['fname'];

            $stmt->execute();

            $row = $stmt->fetch();
            $id = $_SESSION['id'];

            $slist = $dbh->prepare("UPDATE SHAREINFO SET SHARE_USERS=:share_user WHERE SHARE_CODE=:fname");

            $slist->bindParam(':share_user',$str);
            $slist->bindParam(':fname',$fname);

            $str = str_replace($id,'',$row['SHARE_USERS']);
            $slist->execute();

            break;

    }
    
    umask($oldumask);
?>
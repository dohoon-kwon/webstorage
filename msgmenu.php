<?php
    session_start();
    $dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stmt = $dbh->prepare("SELECT * from MSGINFO WHERE MSG_REC_USER = :id");
    $stmt->bindParam(':id',$id);
    $id = $_SESSION['id'];

    $stmt->execute();
    $msgcheck = $stmt->fetchAll();

    if(empty($msgcheck))
    {
        echo "<li class='msg_btn_left' onclick='remove_msg_all()'><a>알림 전체 삭제</a></li>";
        echo "<li class='msg_btn_right' onclick='remove_msg_read()'><a>읽은 알림 삭제</a></li>";
        echo "<li><a>알림이 없습니다.</a></li>";
    }
    else
    {
        echo "<li class='msg_btn_left' onclick='remove_msg_all()'><a>알림 전체 삭제</a></li>";
        echo "<li class='msg_btn_right' onclick='remove_msg_read()'><a>읽은 알림 삭제</a></li>";

        foreach($msgcheck as $msgdata)
        {
            $pk_num = $msgdata['MSG_NUM'];
            $user_list = $msgdata['USER_LIST'];

            if($msgdata['READ_BOOL'] === '0')
            {
                $data = "[" . $msgdata["MSG_SEND_USER"] . ']<br>[ 내용 ]' . $msgdata["MSG_CONTENT"];
                echo ("<li onclick='join_share(\"$pk_num\",\"$user_list\")' class='msg_content'><a>$data</a></li>");
            }
            else
            {
                $data = "[" . $msgdata["MSG_SEND_USER"] . ']<br>[ 내용 ]' . $msgdata["MSG_CONTENT"];
                echo "<li onclick='join_share(\"$pk_num\",\"$user_list\")' class='msg_content_read'><a>$data</a></li>";
            }
            
        }
    }
?>
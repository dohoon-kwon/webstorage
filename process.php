<?php
$dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
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
            header("Location: main.php?id={$check['id']}&pw={$check['pw']}&grade={$check['grade']}"); 
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
            echo("<script>location.replace('login.html');</script>");
        }
        else{
            $stmt = $dbh->prepare("INSERT INTO USERINFO (id, pw, tel, name) VALUES (:id, :pw, :tel, :name)");
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':pw',$pw);
            $stmt->bindParam(':tel',$tel);
            $stmt->bindParam(':name',$name);
            $id = $_POST['id'];
            $pw = $_POST['pw'];
            $tel = $_POST['tel'];
            $name = $_POST['name'];
            $stmt->execute();
            header("Location: login.html");
        }
        break;
    
    case 'upload':
        ini_set("display_errors", "1");
        $uploaddir = '/home/samba/userfile';
        $uploadfile = $uploaddir.$_FILES['file']['name'];
        echo '<pre>';
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
        } else {
            print "파일 업로드 공격의 가능성이 있습니다!\n";
        }
        echo '자세한 디버깅 정보입니다:';
        print_r($_FILES);
        print "</pre>";
        break;
    case 'insert':
        $stmt = $dbh->prepare("INSERT INTO BOARD_TOPIC (title, name, description, created) VALUES (:title, :name, :description, now())");
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':name',$name);
    
        $title = $_POST['title'];
        $description = $_POST['description'];
        $name = $_POST['id'];
        $stmt->execute();
        header("Location: board.php?id={$_POST['id']}&pw={$_POST['pw']}&grade={$_POST['grade']}");
        break;
    case 'comment':
        $stmt = $dbh->prepare("INSERT INTO BOARD_COMMENT (boardnum, name, description, created) VALUES (:topic_id, :name, :description, now())");
        $stmt->bindParam(':topic_id',$topic_id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':description',$description);

        $topic_id = $_POST['topic_id'];
        $name = $_POST['id'];
        $description = $_POST['commenttext'];
        $stmt->execute();
        header("Location: board_read.php?topic_id={$_POST['topic_id']}&id={$_POST['id']}&pw={$_POST['pw']}&grade={$_POST['grade']}");
        break;

    case 'change':
        $stmt = $dbh->prepare("UPDATE USERINFO SET id=:id, pw =:pw, tel=:tel, name=:name, grade=:grade WHERE id=:cid");
        $stmt->bindParam(':cid',$cid);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':pw',$pw);
        $stmt->bindParam(':tel',$tel);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':grade',$grade);

        $cid = $_POST['cid'];
        $id = $_POST['id'];
        $pw = $_POST['pw'];
        $tel = $_POST['tel'];
        $name = $_POST['name'];
        $grade = $_POST['grade'];

        $stmt->execute();
        header("Location: tool.php?id={$_POST['oid']}&pw={$_POST['opw']}&grade={$_POST['ograde']}");
        break;
    }
?>

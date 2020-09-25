<?php
$dbh = new PDO('mysql:host=localhost;dbname=cloud', 'root', '1234',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$stmt = $dbh->prepare('SELECT * FROM BOARD_TOPIC');
$stmt->execute();
$list = $stmt->fetchAll();

if(!empty($_GET['topic_id'])) {
    $stmt = $dbh->prepare('SELECT * FROM BOARD_TOPIC WHERE topic_id = :topic_id');
    $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $topic_id = $_GET['topic_id'];
    $stmt->execute();
    $topic = $stmt->fetch();
}
$id = $_GET['id'];
$pw = $_GET['pw'];
$grade = $_GET['grade'];

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
    $stmt = $dbh->prepare('select count(*) as cnt from BOARD_TOPIC');
    $stmt->execute();
    $list = $stmt->fetch();

    $allPost = $list['cnt']; //전체 게시글의 수

	$onePage = 15; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수
    if($page < 1 || ($allPage && $page > $allPage)) {
?>
	<script>

alert("존재하지 않는 페이지입니다.");

history.back();

</script>

<?php
exit;
}

$oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
$currentSection = ceil($page / $oneSection); //현재 섹션
$allSection = ceil($allPage / $oneSection); //전체 섹션의 수

$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

if($currentSection == $allSection) {
$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
} else {
$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
}

$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

$paging = '<ul>'; // 페이징을 저장할 변수

//첫 페이지가 아니라면 처음 버튼을 생성

if($page != 1) { 
$paging .= '<li class="page page_start"><a href="./board.php?id='.$id.'&pw='.$pw.'&grade='.$grade.'&page=1"><img src="img/page_pprev.png"></img></a></li>';
}
//첫 섹션이 아니라면 이전 버튼을 생성

if($currentSection != 1) { 
$paging .= '<li class="page page_prev"><a href="./board.php?id='.$id.'&pw='.$pw.'&grade='.$grade.'&page=' . $prevPage . '"><img src="img/page_prev.png"></img></a></li>';
}


for($i = $firstPage; $i <= $lastPage; $i++) {
if($i == $page) {
$paging .= '<li class="page current">' . $i . '</li>';

} else {

$paging .= '<li class="page"><a href="./board.php?id='.$id.'&pw='.$pw.'&grade='.$grade.'&page=' . $i . '">' . $i . '</a></li>';
}
}

//마지막 섹션이 아니라면 다음 버튼을 생성

if($currentSection != $allSection) { 
$paging .= '<li class="page page_next"><a href="./board.php?id='.$id.'&pw='.$pw.'&grade='.$grade.'&page=' . $nextPage . '"><img src="img/page_next.png"></img></a></li>';
}

//마지막 페이지가 아니라면 끝 버튼을 생성
if($page != $allPage) { 
$paging .= '<li class="page page_end"><a href="./board.php?id='.$id.'&pw='.$pw.'&grade='.$grade.'&page=' . $allPage . '"><img src="img/page_nnext.png"></img></a></li>';
}
$paging .= '</ul>';

/* 페이징 끝 */
$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문


$stmt = $dbh->prepare('select * from BOARD_TOPIC' . $sqlLimit);
$stmt->execute();
$list = $stmt->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판</title>
        <link rel="stylesheet" href="default.css">
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="board.css">
        <style>
           
        </style>
    </head>
   
    <body>
        <nav>
            <ul>
                <li><a class="idinfo"><?=$_GET['id']?>님 환영합니다.</a></li>
                <li><a class="logout" href="login.php">로그아웃</a></li>
            </ul>
            <ul class="top_menu">
                <li class="top_menu_item"><a href="main.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">홈페이지 정보</a></li>
                <li class="top_menu_item"><a href="upload.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">파일 저장소</a></li>
                <li class="top_menu_item"><a href="board.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">게시판 정보</a></li>
                <li class="top_menu_item"><a href="tool.php?id=<?=$_GET['id']?>&pw=<?=$_GET['pw']?>&grade=<?=$_GET['grade']?>">홈페이지 관리</a></li>
            </ul>
        </nav>

        <nav>
            <ul class="btm_list">
                <li class="btm_list_item_title">게시글목록</li>
                <li class='btm_list_item'><input type="button" value="새로운 글 작성" onClick="location.href='board_write.php?id=<?=$id?>&pw=<?=$pw?>&grade=<?=$grade?>'"/></li>
                <?php
                    foreach($list as $row) {
                    echo "<li class='btm_list_item'><a href=\"board_read.php?topic_id={$row['topic_id']}&id={$id}&pw={$pw}&grade={$grade}\">".htmlspecialchars($row['title'])."</a></li>";
                    }
                ?>
            </ul>
            <div class="paging">
                <?php echo $paging ?>
            </div>
        </nav>
    </body>
</html>

<?php

require_once "./layout.inc"; // 레이아웃을 include 함
require_once "./db.php";


$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 임시 스타일 추가



$v=$_POST['v'];
$bn=$_POST['bn'];
$id = $_POST['id'];
$password = $_POST['password'];
$content = $_POST['content'];

$db = new DBC;

$db->DBI();

$db->query="insert into comment values (null,'".$v."', null,'".date('Y-m-d H:i:s')."','".$content."','".$id."','".$password."','".$bn."')";
$db->DBQ();
//$coNo = $db->DBInsertID();

//$coNo = $db->result->insert_id();
//$db->query= "update comment set co_order = co_no where co_no ='".$coNo."'";
//$db->DBQ();

if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력

{

echo "<script>alert('댓글달기에  실패했습니다.')</script>";

} else

{

echo "<script>location.replace('./".$bn."/view.php?v=".$v."')</script>";
}

$db->DBO();

?>

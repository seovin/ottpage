<?php

require_once "./layout.inc"; // 레이아웃을 include 함

require_once "./db.php";



$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 임시 스타일 추가

$v=$_POST['v'];
$bn=$_POST['bn'];
$co_no=$_POST['co_no'];


  $db = new DBC;
  $db->DBI();

  // query로 데이터를 수정
  $db->query = "select * from comment where co_no = ".$co_no." ";
  $db->DBQ();

  $db->query ="delete from comment where co_no=".$co_no."";

  $db->DBQ();

  if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
  {
  echo "<script>alert('DB 전송에 실패했습니다.')</script>";
  } else
  {
  echo "<script>location.replace('./".$bn."/view.php?v=".$v."')</script>";
  }

  $db->DBO();







$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

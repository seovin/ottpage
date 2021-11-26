<?php

require_once "./layout.inc"; // 레이아웃을 include 함

require_once "./db.php";



$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 임시 스타일 추가


$v=$_POST['v'];
$bn=$_POST['bn'];


if($bn=='notice')
{

  $db = new DBC;
  $db->DBI();

  // query로 데이터를 수정
  $db->query = "select no, datetime, title, id, content, hit from notice where no = ".$v." ";
  $db->DBQ();

  $db->query ="delete from notice where no=".$v."";

  $db->DBQ();
  $db->query = "select * from comment where bo_no = ".$v." ";
  $db->DBQ();

  $db->query ="delete * from comment where bo_no=".$v."";

  $db->DBQ();

  if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
  {
  echo "<script>alert('DB 전송에 실패했습니다.')</script>";
  } else
  {
  echo "<script>alert('글이 정상적으로 삭제 되었습니다.');location.replace('/page/".$bn."')</script>";
  }

  $db->DBO();

}
else if($bn=='board')
{

  $db = new DBC;
  $db->DBI();

  // query로 데이터를 수정
  $db->query = "select no, datetime, category, title, id, content, hit from board where no = ".$v." ";
  $db->DBQ();

  $db->query ="delete from board where no=".$v."";

  $db->DBQ();

  if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
  {
  echo "<script>alert('DB 전송에 실패했습니다.')</script>";
  } else
  {
  echo "<script>alert('글이 정상적으로 삭제 되었습니다.');location.replace('/page/".$bn."')</script>";
  }

  $db->DBO();

}else if($bn=='programs') // 프로그램 부분
{

  $db = new DBC;
  $db->DBI();

  // query로 데이터를 수정
  $db->query = "select no from programs where no = ".$v." ";
  $db->DBQ();

  $db->query ="delete from programs where no=".$v."";

  $db->DBQ();

  if(!$db->result) // DB에 전송이 실패하면 오류 출력, 성공하면 메시지 출력
  {
  echo "<script>alert('DB 전송에 실패했습니다.')</script>";
  } else
  {
  echo "<script>alert('글이 정상적으로 삭제 되었습니다.');location.replace('/page/".$bn."')</script>";
  }

  $db->DBO();

}





$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

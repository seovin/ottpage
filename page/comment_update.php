<?php

include_once "./layout.inc"; // 레이아웃을 include 함
require_once "./db.php";


$base = new Layout; // Layout class 객체를 생성



$base->link='./style.css'; // 스타일 추가


$v=$_GET['v'];


echo "<script>alert('점검중입니다.')</script>";
echo"<script>location.replace('./board/view.php?v=".$v."')</script>";


$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

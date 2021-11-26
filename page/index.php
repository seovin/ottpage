<?php

include_once "./layout.inc"; // 레이아웃을 include 함
require_once './db.php';


$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 스타일 추가

$db = new DBC;
$db->DBI();
$onepage=5;
$limit=$onepage-5;

$base->style='
div.wrap {border:1px solid #ddd;height:150px;padding:8px;padding-top:2px;width:47%;float:left;text-align:center;}
div.wrap2 {border:1px solid #ddd;height:100%;padding:8px;padding-top:2px;width:96%;float:left;text-align:center;}
div.titletitle {font-size:1.5em; margin-bottom:10px;}
div.box {float:left;width:33%;margin-bottom:15px;}
img{height:200px;}
';
////////////////////////////////공지
$db->query = "select no, title from notice order by no desc limit ".$limit.", ".$onepage.";";
$db->DBQ();

$base->content="
              <div class='wrap'><div class='titletitle' ><a href='./notice'>최신 공지사항</a></div>
              ";

while($nodata = $db->result->fetch_row())
{
  $base->content = $base->content."
      <div class='title'><a href='./notice/view.php?v=".$nodata[0]."'>".$nodata[1]."</a></div>
      ";
}
////////////////////////////////////게시판
$db->query = "select no, title from board order by no desc limit ".$limit.", ".$onepage;
$db->DBQ();

$base->content= $base->content."
              </div><div class='wrap'><div class='titletitle' ><a href='./board'>최신 글</a></div>
              ";

while($bodata = $db->result->fetch_row())
{
  $base->content = $base->content."
      <div class='title'><a href='./board/view.php?v=".$bodata[0]."'>".$bodata[1]."</a></div>
      ";
}
////////////////////////////////////프로그램
$db->query = "select no, title, image from programs order by no desc limit 0, 6";
$db->DBQ();

$base->content= $base->content."
              </div><div class='wrap2'><div class='titletitle' ><a href='./programs'>최신 프로그램</a></div>
              ";

while($prodata = $db->result->fetch_row())
{
  $base->content = $base->content."
    <div class='box'>
      <div class='title'><a href='./programs/view.php?v=".$prodata[0]."'>".$prodata[1]."</a></div>
      <div class='image'><a href='./programs/view.php?v=".$prodata[0]."'><img class='maxwidth' src='".$prodata[2]."'/></a></div>
      </div>"
      ;
}

////////////////////////////////////

$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

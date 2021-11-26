<?php

include_once "./layout.inc"; // 레이아웃을 include 함
require_once './db.php';


$base = new Layout; // Layout class 객체를 생성



$base->link='./style.css'; // 스타일 추가


$db = new DBC;

$db->DBI();

$base->style='
div.wrap {border:1px solid #ddd;min-height:120px;padding:8px;padding-top:2px;width:98%;float:left;text-align:center;}
div.wrap2 {border:1px solid #ddd;min-height:400px;padding:8px;padding-top:2px;width:48%;float:left;text-align:center;}

div.titletitle {font-size:1.5em; margin-bottom:10px;}
div.box {float:left;width:33%;margin-bottom:15px;}
img{height:200px;}
';
////////////////////////////////공지
$db->query = "select id, mail, permit from member where id ='".$_SESSION['id']."'";
$db->DBQ();
$data = $db->result->fetch_row();
$base->content=$base->content."
              <div class='wrap'><h3><b>내정보</b></h3>

              <div class='id' >아이디 : ".$data[0]."</div>
              <div class='mail' >메일 : ".$data[1]."</div>
            
              ";
              switch($_SESSION['permit'])
              {
                case 1 : $base->content=$base->content."<div class='mail' >권한 : 일반회원</div>";
                  break;
                case 2 : $base->content=$base->content."<div class='mail' >권한 : 특별회원</div>";
                  break;
                case 3 : $base->content=$base->content."<div class='mail' >권한 : 관리자</div>";
                  break;
              }

              $base->content=$base->content."
                              </div>
                                        ";


$db->query = "select id, title ,no from board where id ='".$_SESSION['id']."' order by no desc";
$db->DBQ();
$base->content=$base->content."
                  <div class='wrap2'>
                  <div class='titlelist' ><h3><b>내가 쓴 글</b></h3></div>
                          ";
while($bodata = $db->result->fetch_row()){
$base->content=$base->content."
              <div class='title' ><a href=./board/view.php?v=".$bodata[2].">".$bodata[1]."</a></div>";
}
$base->content=$base->content."
                </div>
                          ";

///////////////////////////////////////////
$db->query = "select co_id, co_content, board_no from comment where co_id ='".$_SESSION['id']."' order by co_no desc";
$db->DBQ();
$base->content=$base->content."
                  <div class='wrap2'>
                  <div class='commentlist' ><h3><b>내가 쓴 댓글</b></h3></div>
                          ";
while($codata = $db->result->fetch_row()){
$base->content=$base->content."
              <div class='comment' ><a href=./board/view.php?v=".$codata[2].">".$codata[1]."</a></div>";
}
$base->content=$base->content."
                </div>
                          ";




$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

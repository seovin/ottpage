<?php

require_once '../layout.inc';

require_once '../db.php';



$base = new Layout;

$base->link = '../style.css';



$v = $_GET['v'];




if(!isset($v))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}


$base->style='

	div.wrap {border:1px solid #ddd;min-height:450px;padding:8px;}

	div.wrap div {padding:8px;}

	div.title{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}

	div.title > h2{margin:0;}

	div.name, div.datetime, div.category{float:left; margin-right:10px;}

  div.hit {float:right;}

	div.content{border:2px solid #ddd;margin-top:40px;min-height:170px;}

  div.update, div.delete, div.list {float:right;margin-left:1%; }

  div.commentwrite{border:2px solid #ddd;margin-top:40px;padding:40px;}
  div.comment{border:1px solid #ddd;min-height:20px;padding:8px; }
  div.cocontent{border:2px solid #ddd;margin-top:30px;}

	div#paging{text-align:center;}

	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > a:hover{border:1px solid #ddd;}

	';




$db = new DBC;

$db->DBI();

	$db->query = "select no, datetime, title, id, content, hit ,pass from notice where no=".$v." limit 0, 1";

	$db->DBQ();

	$data = $db->result->fetch_row();



	///////////////////////////////////////
if(isset($_SESSION['id'])){

	$db->query = "select id, pass, permit from member where id='".$_SESSION['id']."' and permit='".$_SESSION['permit']."'";


	$db->DBQ();

	$pass = $db->result->fetch_row();
	///////////////////////////////////////


if(!isset($data))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}
}

if($pass[0] = $data[3] && $pass[1]==$data[6] && $pass[2]=='3')
{
	$base->content = $base->content."
		<div class='wrap'>

			<div class='title'>".$data[2]."</div>
			<div class='name'><b>".$data[3]."</b></div>
      <div class='hit'>조회 ".$data[5]." </div>
			<div class='datetime'>".$data[1]." </div>
			<div class='content'>".nl2br($data[4])."</div>
      <div class='list'><a href='./'>목록</a></div>
      <div class='delete'>
      <form action='../delete.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='v' value='".$v."'>
        <input type='hidden' name='bn' value='notice'>
        <input type='submit' value='삭제'>
      </form></div>

      <div class='update'>
      <a href='../write_update.php?bn=notice&v=".$data[0]."'>수정</a></div>



		</div>";
}else{
  $base->content = $base->content."
		<div class='wrap'>

			<div class='title'>".$data[2]."</div>
			<div class='name'><b>".$data[3]."</b></div>
      <div class='hit'>조회 ".$data[5]." </div>
			<div class='datetime'>".$data[1]." </div>
			<div class='content'>".nl2br($data[4])."</div>
      <div class='list'><a href='./'>목록</a></div>



      </div>";


		}




$db->query = "update notice set hit = hit + 1 where no = ".$v."";

$db->DBQ();


$base->LayoutMain();

?>

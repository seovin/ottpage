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


function ThisTable($cate, $bmenu)
{
	foreach($bmenu as $key => $value)
	{
		if($cate == $value)
		{
			$cate = $key;
		}

  }
	return $cate;

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

	$db->query = "select no, datetime, category, title, id, content, hit ,pass from board where no=".$v." limit 0, 1";

	$db->DBQ();

	$data = $db->result->fetch_row();
	$data[6] = $data[6]+1;

	$cate = ThisTable($data[2], $base->bmenu);

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


if(($pass[0] = $data[4] && $pass[1]==$data[7])|| $pass[2]=='3')
{
	$base->content = $base->content."
		<div class='wrap'>
    <div class='category'><a href='./?tn=".$data[2]."'>".$cate."</a></div>
			<div class='title'>".$data[3]."</div>
			<div class='name'><b>".$data[4]."</b></div>
      <div class='hit'>조회 ".$data[6]." </div>
			<div class='datetime'>".$data[1]." </div>
			<div class='content'>".nl2br($data[5])."</div>
      <div class='list'><a href='./'>목록</a></div>
      <div class='delete'>
      <form action='../delete.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='v' value='".$v."'>
        <input type='hidden' name='bn' value='board'>
        <input type='submit' value='삭제'>
      </form></div>

      <div class='update'>
      <a href='../write_update.php?bn=board&v=".$data[0]."'>수정</a></div>

      <div class='commentwrite'>
      <form action='../comment.php' method='post' enctype='multipart/form-data'>
          <input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
          <input type='hidden' name='v' value='".$data[0]."'/>
          <input type='hidden' name='bn' value='board'/>
          <input type='hidden' name='id' value='".$_SESSION['id']."' />
          <input type='hidden' name='password' value='".$pass[1]."' />
          <div class='coname'><b>".$_SESSION['id']."</b></div>
          <div><textarea name='content' cols='80' rows='2' style=width:90%;margin-right:1%; placeholder='댓글 내용을 입력하세요.'></textarea><input type='submit' value='댓글 작성'/></div>
      </form></div>


		</div>";
}else{
  $base->content = $base->content."
		<div class='wrap'>
    <div class='category'><a href='./?tn=".$data[2]."'>".$cate."</a></div>
			<div class='title'>".$data[3]."</div>
			<div class='name'><b>".$data[4]."</b></div>
      <div class='hit'>조회 ".$data[6]." </div>
			<div class='datetime'>".$data[1]." </div>
			<div class='content'>".nl2br($data[5])."</div>
      <div class='list'><a href='./'>목록</a></div>

      <div class='commentwrite'>
      <form action='../comment.php' method='post' enctype='multipart/form-data'>
          <input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
          <input type='hidden' name='v' value='".$data[0]."'/>
          <input type='hidden' name='bn' value='board'/>
          <input type='hidden' name='id' value='".$_SESSION['id']."' />
          <input type='hidden' name='password' value='".$pass[1]."' />
          <div class='coname'><b>".$_SESSION['id']."</b></div>
					<div><textarea name='content' cols='80' rows='2' style=width:90%;margin-right:1%; placeholder='댓글 내용을 입력하세요.'></textarea><input type='submit' value='댓글 작성'/></div>
      </form></div>

      </div>";


		}
}
else{
	$base->content = $base->content."
		<div class='wrap'>
		<div class='category'><a href='./?tn=".$data[2]."'>".$cate."</a></div>
			<div class='title'>".$data[3]."</div>
			<div class='name'><b>".$data[4]."</b></div>
			<div class='hit'>조회 ".$data[6]." </div>
			<div class='datetime'>".$data[1]." </div>
			<div class='content'>".nl2br($data[5])."</div>
			<div class='list'><a href='./'>목록</a></div>

			<div class='commentwrite'>
      <form action='../comment.php' method='post' enctype='multipart/form-data'>
          <input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

          <input type='hidden' name='bn' value='board'/>

          <div class='coname'><b>손님</b></div>
          <div><textarea name='content' cols='80' rows='2' style=width:100% placeholder='로그인을 해주세요.'></textarea></div><input type='submit' value='댓글 작성'/>
      </form></div>

			</div>";
}

$db->query = "select co_no, board_no, datetime ,co_content, co_id, co_bn from comment where co_bn='board' and board_no=".$v."";

$db->DBQ();


while($codata = $db->result->fetch_row())
{
  $datetime = explode(' ', $codata[2]);
  $date = $datetime[0];
  $time = $datetime[1];
  if($date == Date('Y-m-d'))
  {
      $codata[2] = $time;
  } else
  {
      $codata[2] = $date;
  }

if($codata[4]==$_SESSION['id']){

		$base->content = $base->content."
		<div class='comment'>
		<div class='name'><b>".$codata[4]."</b></div>
		<div class='datetime'>".$codata[2]."</div>
		<div class='cocontent'>".nl2br($codata[3])."
		<div class='delete'>
		<form action='../comment_delete.php' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='co_no' value='".$codata[0]."'>
			<input type='hidden' name='bn' value='board'>
			<input type='hidden' name='v' value='".$v."'>
			<input type='submit' value='삭제'>
		</form></div>
		<div class='update'>
		<a href='../comment_update.php?bn=board&v=".$v."'>수정</a></div>
		</div>



		</div>
		";
}
else{
	$base->content = $base->content."
	<div class='comment'>
	<div class='name'><b>".$codata[4]."</b></div>
	<div class='datetime'>".$codata[2]."</div>
	<div class='cocontent'>".nl2br($codata[3])."</div>


	</div>
	";
}

}



$db->query = "update board set hit = hit + 1 where no = ".$v."";

$db->DBQ();


$base->LayoutMain();

?>

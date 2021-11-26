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



function ThisTable($cate, $pmenu)
{
	foreach($pmenu as $key => $value)
	{
		if($cate == $value)
		{
			$cate = $key;
		}

  }
	return $cate;

}
$thisboard = explode('/', $_SERVER['PHP_SELF']);
$bn=$thisboard[2];

$base->style='

	div.wrap {border:1px solid #ddd;min-height:580px;padding:8px;}

	div.wrap div {padding:8px;}

	div.left {margin-top:10px;border:3px solid #aaa;min-width:300px;padding:8px;}

	div.title{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}

	div.title > h2{margin:0;}

	div.content{border:1px solid #ddd; margin-top:20px;}

	img{height:230px;}
	div.image {text-align:center;float:right;}

	div.delete,div.update ,div.list { float:right;}

	div#paging{text-align:center;}

	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}

	div#paging > a:hover{border:1px solid #ddd;}

	';



$db = new DBC;

$db->DBI();

$db->query = "select no, id, date, time, category, title, content, link, OTT, image, genre from programs where no=".$v." limit 0, 1";
$db->DBQ();

$data = $db->result->fetch_row();

if(!isset($data))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}

switch($data[10])
{
	case 1:
		$genre='로맨스/멜로';
		break;
	case 2:
		$genre='코미디';
		break;
	case 3:
		$genre='액션/SF';
		break;
	case 4:
		$genre='공포/스릴러';
		break;
	case 5:
		$genre='다큐/클래식';
		break;
	default:
		$genre='페이지 오류입니다.';
		break;
}



$cate = ThisTable($data[4], $base->pmenu);

$permit=$_SESSION['permit'];

if($permit=='3')
{
	$base->content = $base->content."

		<div class='wrap'>

			<div class='title'><h2>".$data[5]."</h2></div>

			<div class='left'>
			<div class='image'><img class='maxwidth' src='.".$data[9]."'/></div>
			<div class='name'>  작성자 : ".$data[1]."</div>

			<div class='date'>작성일 : ".$data[2]." ".$data[3]."</div>

			<div class='category'>카테고리 : <a href='./?tn=".$data[4]."'>".$cate."</a></div>

			<div class='ott'>OTT : ".$data[8]."</div>

			<div class='genre'>장르 : ".$genre."</div>

			<div class='link'><a href='".$data[7]."' target='_blank'>지금 보러가기</a></div>

			<div class='content'>".nl2br($data[6])."</div>

			</div>
			<div class='delete'>
			<form action='../delete.php' method='post' enctype='multipart/form-data'>
				<input type='hidden' name='v' value='".$v."'>
				<input type='hidden' name='bn' value='".$bn."'>
				<input type='submit' value='삭제'>
			</form></div>
			<div class='update'>
			<a href='../write_update.php?bn=programs&v=".$data[0]."'>수정</a></div>
			<div class='list'><a href='./'>목록</a></div>
		</div>";
}else {
	$base->content = $base->content."

		<div class='wrap'>

			<div class='title'><h2>".$data[5]."</h2></div>

			<div class='left'>
			<div class='image'><img class='maxwidth' src='.".$data[9]."'/></div>
			<div class='name'>  작성자 : ".$data[1]."</div>

			<div class='date'>작성일 : ".$data[2]." ".$data[3]."</div>

			<div class='category'>카테고리 : <a href='./?tn=".$data[4]."'>".$cate."</a></div>

			<div class='ott'>OTT : ".$data[8]."</div>

			<div class='genre'>장르 : ".$genre."</div>

			<div class='link'>프로그램 <a href='".$data[7]."' target='_blank'>보러가기</a></div>

			<div class='content'>".nl2br($data[6])."</div>

			</div>
<div class='list'><a href='./'>목록</a></div>
		</div>"
			;
}





$base->LayoutMain();

?>

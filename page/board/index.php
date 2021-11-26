<?php

require_once '../layout.inc';
require_once '../db.php';


$base = new Layout;
$base->link = '../style.css';


//현재카테고리

if(isset($_GET['tn'])){
  $tn=$_GET['tn'];
}else{
  $tn='all';
}


//하나의 페이지에 보여줄 글
$onepage=20;


if(empty($_GET['p']))
{
	$_GET['p']=1;
}

$db = new DBC;
$db->DBI();


if($tn=='all') //all 부분
{
	$db->query = "select count(*) from board";
	$db->DBQ();
	$quantity = $db->result->fetch_row();

	$limit=$onepage*$_GET['p']-$onepage;

  if(isset($_GET['searchColumn']) && isset($_GET['searchText']))
  {
	   $searchColumn = $_GET['searchColumn'];
     $searchText = $_GET['searchText'];
     $db->query ="select no, datetime, category, title, id, hit from board where ".$searchColumn." like '%".$searchText."%' order by no desc limit ".$limit.", ".$onepage;
  }
  else {
    $db->query = "select no, datetime, category, title, id, hit from board order by no desc limit ".$limit.", ".$onepage;
  }


} else
{
  $db->query = "select count(*) from board where category='".$tn."'";
	$db->DBQ();
	$quantity = $db->result->fetch_row();

	$limit=$onepage*$_GET['p']-$onepage;

  if(isset($_GET['searchColumn']) && isset($_GET['searchText']))
  {
	   $searchColumn = $_GET['searchColumn'];
     $searchText = $_GET['searchText'];
     $db->query ="select no, datetime, category, title, id, hit from board where category='".$tn."' and ".$searchColumn." like '%".$searchText."%' order by no desc limit ".$limit.", ".$onepage;
  }
  else{
    $db->query = "select no, datetime, category, title, id, hit from board where category='".$tn."'  order by no desc limit ".$limit.", ".$onepage;
  }


}



	$base->style='
	div.wrap {border:1px solid #ddd;min-height:13px;padding:8px;padding-top:2px;}

  div.no {float:left;width:10%;text-align:center;}
  div.title {float:left;width:50%;text-align:center;}
  div.name {float:left;width:15%;text-align:center;}
  div.datetime {float:left;width:15%;text-align:center;}
  div.hit {float:left;width:10%;text-align:center;}


	div.content{border:1px solid #ddd;margin-top:10px;min-height:170px;}
	div.image {text-align:center;min-height:316px;}
	img{max-height:330px;}
	div#paging{text-align:center;}
	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > a:hover{border:1px solid #ddd;}
	';



	$db->DBQ();

  $base->content = $base->content."

  <div class='wrap'>
      <div class='no'>번호</div>
      <div class='title'>제목</div>
      <div class='name'>작성자</div>
      <div class='datetime'>작성일</div>
      <div class='hit'>조회수</div>
  </div>";

	while($data = $db->result->fetch_row())
	{
      foreach(($base->bmenu) as $key => $value)
		{
			if($data[2] == $value)
			{
				$cate = $key;
			}
		}

    $datetime = explode(' ', $data[1]);
    $date = $datetime[0];
    $time = $datetime[1];
    if($date == Date('Y-m-d'))
    {
        $data[1] = $time;
    } else
    {
        $data[1] = $date;
    }


		$base->content = $base->content."

		<div class='wrap'>
			  <div class='no'><a href='./view.php?v=".$data[0]."'>".$data[0]."</a></div>
				<div class='title'><a href='./view.php?v=".$data[0]."'>".$data[3]."</a></div>
				<div class='name'>".$data[4]."</div>
        <div class='datetime'>".$data[1]."</div>
        <div class='hit'>".$data[5]."</div>


		</div>";

	}


	$thispage = $_GET['p']; //현재 페이지

	$totalpage=(int)ceil($quantity[0]/$onepage); //전체 페이지

	$oneblock = 10; //페이지 블록 한 페이지에 몇개 보일지.

	if($thispage>$totalpage)
	{
    if($totalpage==0){

    }else
		  echo "<script>alert('존재하지 않는 페이지입니다.');location.replace('./');</script>";
	}



	$thisblock = (int)(ceil($thispage/$oneblock)-1);

	$lastblock = (int)(ceil($totalpage/$oneblock)-1);

	$startnum = (int)($thisblock*$oneblock+1);

	$endnum = (int)($thisblock*$oneblock+$oneblock+1);

  $paging='';

	if($thispage!=1) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=1'><< </a>";

	if($thisblock!=0) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".($thisblock*$lastblock)."'>< </a>";

	for($i=$startnum; $i<$endnum; ++$i)

	{

		if($i>$totalpage) break;

		if($i==$thispage) $paging = $paging."<b>".$i."</b>";

		else $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$i."".$subString."'>".$i."</a>";

	}

	if($thisblock!=$lastblock) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$endnum."'> ></a>";

	if($thispage!=$totalpage) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$totalpage."'> >></a>";


	$base->content = $base->content.
  "<div id='paging'>".$paging."</div>

  <div class='searchBox'>

       <form action='./index.php' method='get'>

         <select name='searchColumn'>

           <option value='title'>제목</option>

           <option value='content'>내용</option>

           <option value='id'>작성자</option>
           </select>

         <input type='text' name='searchText'>
         <input type='hidden' name='tn' value='".$tn."' />
         <button type='submit'>검색</button>

       </form>

     </div>

 ";




$base->LayoutMain();

?>

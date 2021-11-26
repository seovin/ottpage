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
$onepage=4;


if(empty($_GET['p']))
{
	$_GET['p']=1;
}



$db = new DBC;
$db->DBI();


if($tn=='all') //latest 부분
{
	$db->query = "select count(*) from programs";
	$db->DBQ();
	$quantity = $db->result->fetch_row();

	$limit=$onepage*$_GET['p']-$onepage;

  if( isset($_GET['searchText']))
  {
     $searchText = $_GET['searchText'];
     $db->query ="select no, id, date, time, category, title, content, link, ott, image, genre from programs where title like '%".$searchText."%' order by no desc limit ".$limit.", ".$onepage;
  }else{
      $db->query = "select no, id, date, time, category, title, content, link, ott, image, genre from programs order by no desc limit ".$limit.", ".$onepage;
  }

} else{
  $db->query = "select count(*) from programs where category='".$tn."'";
	$db->DBQ();
	$quantity = $db->result->fetch_row();

	$limit=$onepage*$_GET['p']-$onepage;

  if(isset($_GET['searchText']))
  {
     $searchText = $_GET['searchText'];
     $db->query ="select no, id, date, time, category, title, content, link, ott, image, genre from programs where and category='".$tn."' and title like '%".$searchText."%' order by no desc limit ".$limit.", ".$onepage;
  }else{
      $db->query = "select no, id, date, time, category, title, content, link, ott, image, genre from programs where category='".$tn."' order by no desc limit ".$limit.", ".$onepage;
  }


}


	$base->style='
	div.wrap {margin-bottom:10px;border:3px solid #acb;min-height:400px;padding:8px;text-align:center;width:46%;float:left;margin-right:10px;}
	div.wrap div {padding:8px;}
	div.left {float:left;width:50%;}
	div.right {float:right;width:40%;width:43%;}
	div.title{border:3px solid #acb;text-align:center;}
	div.title > h2{margin:0;}
	div.content{border:1px solid #ddd;margin-top:10px;min-height:170px;}
	div.image {text-align:center;height:330px;}
	img{height:330px;}
	div#paging{text-align:center;}
	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > a:hover{border:1px solid #ddd;}
	';



	$db->DBQ();

  $base->content = $base->content."
  <div class='searchBox'>

       <form action='./index.php' method='get'>

         <input type='text' name='searchText'>
         <input type='hidden' name='tn' value='".$tn."' />
         <button type='submit'>검색</button>

       </form>
       </div>";

	while($data = $db->result->fetch_row())
	{
      foreach(($base->pmenu) as $key => $value)
		{
			if($data[4] == $value)
			{
				$cate = $key;
			}
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


		$base->content = $base->content."

		<div class='wrap'>
	   <div class='title'><h2><a href='./view.php?v=".$data[0]."'>".$data[5]."</a></h2></div>
     <div class='image'><a href='./view.php?v=".$data[0]."'><img class='maxwidth' src='.".$data[9]."'/></a></div>
     <div class='category'>카테고리 : <a href='./?tn=".$data[4]."'>".$cate."</a></div>
	   <div class='genre'>장르 : ".$genre."</div>
		</div>";

	}



	$thispage = $_GET['p']; //현재 페이지

	$totalpage=(int)ceil($quantity[0]/$onepage); //전체 페이지

	$oneblock = 10; //페이지 블록 한 페이지에 몇개 보일지.

	if($thispage>$totalpage )
	{

    if($totalpage==0){

    }else{
      echo "<script>alert('존재하지 않는 페이지입니다.');location.replace('./');</script>";
    }

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

		else $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$i."'>".$i."</a>";

	}

	if($thisblock!=$lastblock) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$endnum."'> ></a>";

	if($thispage!=$totalpage) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$totalpage."'> >></a>";



	$base->content = $base->content."<div id='paging'>".$paging."</div>";





$base->LayoutMain();

?>

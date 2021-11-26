<?php

require_once "./layout.inc"; // 레이아웃을 include 함
require_once './db.php';

$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 임시 스타일 추가

$v=$_GET['v'];
$bn=$_GET['bn'];

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

if($bn=='notice')
{
  $db = new DBC;
  $db->DBI();
  $db->query = "select no, datetime, title, id, content, hit from notice where no = ".$v." ";
  $db->DBQ();

  $data = $db->result->fetch_row();
  $cate = ThisTable($data[2], $base->bmenu);

  if(isset($_GET['v'])){
    $base->content="

  	<form action='./writing_update.php' method='post' enctype='multipart/form-data'>

  		<div>

  			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

  			<input type='hidden' name='bn' value='".$bn."' />
        <input type='hidden' name='v' value='".$v."' />

  			<div>제목 <input type='text' name='title' size='80' value='".$data[2]."'/></div>

  			<div>글내용<textarea name='content' cols='90' rows='20' >".$data[4]."</textarea></div>

  			<input type='submit' value='수정'/>

  		</div>

  	</form>

  	";
	}
}
else if($bn=='board')
{
  $db = new DBC;
  $db->DBI();
  $db->query = "select no, datetime, category, title, id, content, hit from board where no = ".$v." ";
  $db->DBQ();

  $data = $db->result->fetch_row();
  $cate = ThisTable($data[2], $base->bmenu);

  foreach(($base->bmenu) as $key => $value)
	{
    if($key!='최신')
      $bmenu = $bmenu."<option value='".$value."'>".$key."</option>";
	}


  if(isset($_GET['v'])){

    $base->content="

  	<form action='./writing_update.php' method='post' enctype='multipart/form-data'>

  		<div>

  			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

  			<input type='hidden' name='bn' value='".$bn."' />
        <input type='hidden' name='v' value='".$v."' />

  			<div>제목 <input type='text' name='title' size='80' value='".$data[3]."'/></div>

  			<div>게시판 선택
  			<select name='category'><option value='".$data[2]."'selected disabled hidden>".$cate."</option>
  				".$bmenu."

  			</select></div>

  			<div>글내용<textarea name='content' cols='90' rows='20' >".$data[5]."</textarea></div>

  			<input type='submit' value='수정'/>

  		</div>

  	</form>

  	";
  }



}
//프로그램 부분

else if($bn=='programs')
{

  $db = new DBC;
  $db->DBI();
  $db->query =  "select no, id, date, time, category, title, content, link, ott, image, genre from programs where no = ".$v." ";
  $db->DBQ();

  $data = $db->result->fetch_row();
  $cate = ThisTable($data[4], $base->pmenu);

  foreach(($base->pmenu) as $key => $value)
	{

		if($key!='최신')
		{
			$pmenu = $pmenu."<option value='".$value."'>".$key."</option>";

		}

	}

  if(isset($_GET['v'])){

	$base->content="

	<form action='./writing_update.php' method='post' enctype='multipart/form-data'>

		<div>

    <input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

    <input type='hidden' name='bn' value='".$bn."' />
    <input type='hidden' name='v' value='".$v."' />

			<div>제목 <input type='text' name='title' size='80' value='".$data[5]."'/></div>

			<div>카테고리
			<select name='category'>".$cate."</option>
				".$pmenu."

			</select></div>

			<div>제공 OTT

			<input type='checkbox' name='ott1' value='넷플릭스' />넷플릭스

			<input type='checkbox' name='ott2' value='티빙'/>티빙

			<input type='checkbox' name='ott3' value='왓챠'/>왓챠

			<input type='checkbox' name='ott4' value='웨이브'/>웨이브

			<input type='checkbox' name='ott5' value='카카오TV'/>카카오TV

			<input type='checkbox' name='ott6' value='디즈니+'/>디즈니+

			<input type='checkbox' name='ott7' value='애플TV'/>애플TV</div>

			<div>장르

				<select name='genre'><option value='".$data[10]."'selected disabled hidden></option>

					<option value='1'>로맨스/멜로</option>

					<option value='2'>코미디</option>

					<option value='3'>액션/SF</option>

					<option value='4'>공포/스릴러</option>

					<option value='5'>다큐/클래식</option>

				</select>

			</div>

			<div>링크 <input type='text' name='link' size='50' value='".$data[7]."'/></div>

			<div><input type='file' name='userfile' id='userfile'  value='".$data[9]."'/></div>

			<div>글내용<textarea name='content' cols='90' rows='20'>".$data[6]."</textarea></div>

			<input type='submit' value='글쓰기'/>

		</div>

	</form>

	";

  }
}



$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

<?php

require_once "./layout.inc"; // 레이아웃을 include 함



$base = new Layout; // Layout class 객체를 생성

$base->link='./style.css'; // 임시 스타일 추가



$bn=$_GET['bn'];


if(($bn == 'notice' || $bn == 'programs') && $_SESSION['permit']!=3)

{

	header("Content-Type: text/html; charset=UTF-8");

	echo "<script>alert('접근할 수 없습니다.');history.back('/')</script>";

	exit;

}
else if($bn=='notice')
{


	$base->content="

	<form action='./writing.php' method='post' enctype='multipart/form-data'>

		<div>

			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

			<input type='hidden' name='bn' value='".$bn."' />

			<div>제목 <input type='text' name='title' size='80'/></div>

			<div>글내용<textarea name='content' cols='90' rows='20'></textarea></div>

			<input type='submit' value='글쓰기'/>

		</div>

	</form>

	";

}

else if($bn=='board')
{
	foreach(($base->bmenu) as $key => $value)
	{

			$bmenu = $bmenu."<option value='".$value."'>".$key."</option>";


	}


	$base->content="

	<form action='./writing.php' method='post' enctype='multipart/form-data'>

		<div>

			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

			<input type='hidden' name='bn' value='".$bn."' />

			<div>제목 <input type='text' name='title' size='80'/></div>

			<div>게시판 선택
			<select name='category'>
				".$bmenu."

			</select></div>

			<div>글내용<textarea name='content' cols='90' rows='20'></textarea></div>

			<input type='submit' value='글쓰기'/>

		</div>

	</form>

	";

}
//프로그램 부분

else if($bn=='programs')

{

  foreach(($base->pmenu) as $key => $value)
	{


			$pmenu = $pmenu."<option value='".$value."'>".$key."</option>";


	}


	$base->content="

	<form action='./writing.php' method='post' enctype='multipart/form-data'>

		<div>

			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />

			<input type='hidden' name='bn' value='".$bn."' />

			<div>제목 <input type='text' name='title' size='80'/></div>

			<div>카테고리
			<select name='category'>
				".$pmenu."

			</select></div>

			<div>제공 OTT

			<input type='checkbox' name='ott1' value='넷플릭스'/>넷플릭스

			<input type='checkbox' name='ott2' value='티빙'/>티빙

			<input type='checkbox' name='ott3' value='왓챠'/>왓챠

			<input type='checkbox' name='ott4' value='웨이브'/>웨이브

			<input type='checkbox' name='ott5' value='카카오TV'/>카카오TV

			<input type='checkbox' name='ott6' value='디즈니+'/>디즈니+

			<input type='checkbox' name='ott7' value='애플TV'/>애플TV</div>

			<div>장르

				<select name='genre'>

					<option value='1'>로맨스/멜로</option>

					<option value='2'>코미디</option>

					<option value='3'>액션/SF</option>

					<option value='4'>공포/스릴러</option>

					<option value='5'>다큐/클래식</option>

				</select>

			</div>

			<div>링크 <input type='text' name='link' size='50'/></div>

			<div><input type='file' name='userfile' id='userfile'/></div>

			<div>글내용<textarea name='content' cols='90' rows='20'></textarea></div>

			<input type='submit' value='글쓰기'/>

		</div>

	</form>

	";

}



$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력

?>

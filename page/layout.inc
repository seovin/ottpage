<?php

// 세션을 시작합니다.

// 이후에 사용 할 로그인 용.

session_start();


if(!isset($_SESSION['id']) && isset($_SESSION['permit']) )
{
	echo "<script>location.replace('/page/logout.php');</script>";
}

// class를 이용한 객체 지향 방식
class Layout
{
	public $title="OTT 다모아"; // 웹 페이지 제목
	public $menu = array('Board'=>'board', 'Programs'=>'programs', 'Notice'=>'notice');
	public $pmenu = array( '드라마'=>'drama', '영화'=>'movie', '애니메이션'=>'animation');
	public $bmenu = array( '자유게시판'=>'free','함께게시판'=>'with');
	public $link; // CSS 링크 태그
	public $style; // 스타일 적용
	public $content; // 메인 컨텐츠
	public $board; //게시판 이름 지정
	private $sub; // 서브 메뉴용 변수
	private $login; // 로그인이나 로그아웃을 출력



	// 레이아웃을 출력
	public function LayoutMain()
	{
		echo $this->ThisBoard(); // 현재 게시판의 이름을 확인
		echo "<!DOCTYPE html>\n<html lang='ko'>";
		echo "<head>\n<meta charset='utf-8'/>";
		echo "<title>".$this->title."</title>";
		echo $this->LayoutStyle(); // 스타일을 레이아웃에 추가.
		echo "</head>\n<body>\n<div id='container'>";
		echo	$this->LayoutHeader(); // 헤더 부분을 레이아웃에 추가
		echo	$this->LayoutContent(); // 컨텐츠 부분을 레이아웃에 추가
		echo	$this->LayoutSide(); // 사이드 부분을 레이아웃에 추가
		echo	$this->LayoutFooter(); // 푸터 부분을 레이아웃에 추가
		echo "</div></body>\n</html>";
	}



	// 현재 게시판의 이름을 확인
	public function ThisBoard()
	{
		$this->board = explode('/', $_SERVER['PHP_SELF']);
	}



	// 스타일을 추가
	public function LayoutStyle()
	{
		echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/> ";
    echo "<style>".$this->style."</style>";
	}



	// 헤더 부분 추가
	public function LayoutHeader()
	{
		$this->LayoutLogin();
		echo "<header>
			<div id='logo'><h1><a href='/page'>OTT 다모아</a></h1></div>
				<nav id='menu'>
					";
		$this->LayoutMenu($this->menu,0); // $menu 배열을 이용해서 메뉴 부분을 호출
    echo "		</nav>
              <nav id='login'>".$this->login."</nav>

              </header>";

	}

	public function LayoutMenu($menu, $side) // 배열과 <li> 을 이용해서 메뉴 부분을 호출
	{
    foreach($menu as $key => $value)
		{
			$this->ThisMenu($key, $value, $side);
    }
	}


	public function ThisMenu($key, $value ,$side) //받아온 값으로 메뉴를 출력함
	{
    $thismenu = "";
		if($side=='1')
		{
			if(strpos($_SERVER['REQUEST_URI'], $value)==false)
			{
				$thismenu = $thismenu."<li><a href='./?tn=".$value."'>".$key."</a></li>";
			} else {
				$thismenu = $thismenu."<li><b style='border-bottom:4px solid #90bbff;'>".$key."</b></li>";
			}

		} else {
			if(strpos($_SERVER['PHP_SELF'], $value)==false)
			{
				$thismenu = $thismenu."<li><a href='/page/".$value."'>".$key."</a></li>";
			} else {
				$thismenu = $thismenu."<li><b style='border-bottom:4px solid #90bbff;'>".$key."</b></li>";
			}
		}
		echo $thismenu;
	}



	public function LayoutLogin()
	{
		if(empty($_SESSION['id']))
		{
			if(strpos($_SERVER['PHP_SELF'], "login.php"))
			{
				$this->login="<b style='border-bottom:3px solid #90bbff;'>Login</b>";
			} else {
				$this->login="<a href='/page/login.php'>Login</a>";
			}
		} else {
			$this->login="<a href='/page/logout.php'>Logout</a>";
		}
	}



	// 내용을 추가
	public function LayoutContent()
	{
		echo "<section><article>".$this->content."</article>";
	}


	// 사이드바 추가
	public function SideMenu()
	{
		$this->board=explode('/', $_SERVER['PHP_SELF']);
		switch($this->board[2])
		{
			case "notice" :
				echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>공지사항</a></h3>";
        if($_SESSION['permit']==3)
        {
        		echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
        }
        break;

	    case "programs" :
				echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>프로그램</a></h3>";
				$this->LayoutMenu($this->pmenu, 1);
        if($_SESSION['permit']==3)
			  {
				echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
			  }
				break;

			case "board" :
				echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='".$_SERVER['PHP_SELF']."'>게시판</a></h3>";
				$this->LayoutMenu($this->bmenu, 1);
				if(isset($_SESSION['permit']))
				{
				echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[2]."' style='padding:20px;'>글쓰기</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
				}
				break;

			default :
      if(isset($_SESSION['id']) && isset($_SESSION['permit']))
      {
      echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><b	style='padding:20px;'>";
      switch($_SESSION['permit'])
      {
        case 1 : echo "일반회원";
          break;
        case 2 : echo "특별회원";
          break;
        case 3 : echo "관리자";
          break;
      }
      echo "</b><b style='padding:20px;'>".$_SESSION['id']."</b></div>";

      }
		}

	}



	public function LayoutSide()
	{
		echo "<aside>";
		$this->SideMenu();
		echo "</aside></section>";
	}



	// 푸터 부분 추가
		public function LayoutFooter()
	{
		echo "<footer>Copyright © 2021. seobin All rights reserved. OTT다모아</footer>";
	}

}

?>

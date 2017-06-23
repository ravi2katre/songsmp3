<?php
			// by default we show first page
			$pageNum = 1;

			// if $_GET['page'] defined, use it as page number
			if(isset($_GET['page']))
			{
				$pageNum = $_GET['page'];
			}

			$PAGE = $pageNum;
			// counting the offset
			$offset = ($pageNum - 1) * $rowsPerPage;
			$limit = " LIMIT $offset, $rowsPerPage";

			// how many rows we have in database
			//$result = $db->numrow($pagingqry);
			if($pagingpassid == '' )
				$pagingpassid = 'id';
			$numrows = $db->numrow($pagingqry,$pagingpassid);

			//if records found
			if($numrows>0)
			{
					// how many pages we have when using paging?
					$maxPage = ceil($numrows/$rowsPerPage);

					// print the link to access each page
					$self = $_SERVER['PHP_SELF'].$gets;
					$nav  = '';


					if($pageNum > 2)
					{
						$startpage = $pageNum - 2;
					}
					else
						$startpage = 1;

					$endpage = $startpage + 5;

					if($endpage > $maxPage)
						$endpage = $maxPage+1;

					if($maxPage > 1)
					{
						for($page = $startpage; $page < $endpage; $page++)
						{
						   if ($page == $pageNum)
						   {
							  $nav .= "  "; // no need to create a link to current page
						   }
						   else
						   {
							  $nav .= "";
						   }
						}
					}

					// creating previous and next link
					// plus the link to go straight to
					// the first and last page

					if ($pageNum > 1)
					{
					   $page  = $pageNum - 1;
					   $prev  = "<a href=\"$pagelink$page$htmlpage\">< Prev</a>";
						$gofirst = 1;
					}
					else
					{
					   $prev  = '&nbsp;'; // we're on page one, don't print previous link
					   $first = '&nbsp;'; // nor the first page link
					}

					if ($pageNum < $maxPage)
					{
					   $page = $pageNum + 1;
					   $next = " <a href=\"$pagelink$page$htmlpage\">Next ></a> ";

					}
					else
					{
					   $next = '&nbsp;'; // we're on the last page, don't print next link
					   $last = '&nbsp;'; // nor the last page link
					}

						$jumppage = '';
						$jumppage .= '<form name="frme" method="get" action="'.BASE_PATH.'jumppage.php">';
						$jumppage .= 'Jump to : ';
							$jumppage .= '<select name="page">';
							for($i=1;$i<=$maxPage;$i++)
							{
								if($i == $pageNum)
									$jumppage .= "<option value='$i' selected='selected'>$i</option>";
								else
									$jumppage .= "<option value='$i'>$i</option>";
							}
							$jumppage .= "</select>";
							$jumppage .= "<input type='submit' name='go' value='Go' />";
							$jumppage .= "<input type='hidden' name='pagelink' value='".$pagelink."' />";
							$jumppage .= "<input type='hidden' name='htmlpage' value='".$htmlpage."' />";
						$jumppage .= '</form>';


					if($maxPage > 1)
					{
						// print the navigation link
						$str = "Page (" . $pageNum ."/ ".$maxPage.")<br />";
						$str .=  $first . $prev . $nav . $next . $last . $jumppage ;
						$str .=	"</div>";
					}

					$PAGE_CODE = $str;
					//define("JUMP_PAGE",$jumppage);


		}
		else
		{
			$PAGE_CODE = 'Sorry, No Records Found';
		}



?>
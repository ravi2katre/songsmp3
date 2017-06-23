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
			$result = $db->query($pagingqry);
			$numrows = count($result);
			$result = NULL;
			
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
							  $nav .= "<span class='current'> $page</span> "; // no need to create a link to current page
						   }
						   else
						   {
							  $nav .= " <a href=\"$pagelink$page$htmlpage\">$page</a> ";
						   } 
						}
					}
								
					// creating previous and next link
					// plus the link to go straight to
					// the first and last page
					
					if ($pageNum > 1)
					{
					   $page  = $pageNum - 1;
					   $prev  = " <a href=\"$pagelink$page$htmlpage\">< Prev</a> ";
						$gofirst = 1;
					   $first = " <a href=\"$pagelink$gofirst$htmlpage\" ><< First</a> ";
					} 
					else
					{
					   $prev  = ' <span class="disabled">< prev</span>'; // we're on page one, don't print previous link
					   $first = ' <span class="disabled"><< First</span>'; // nor the first page link
					}
					
					if ($pageNum < $maxPage)
					{
					   $page = $pageNum + 1;
					   $next = " <a href=\"$pagelink$page$htmlpage\">Next ></a> ";
					
					   $last = " <a href=\"$pagelink$maxPage$htmlpage\">Last >></a> ";
					} 
					else
					{
					   $next = '<span class="disabled">Next ></span>'; // we're on the last page, don't print next link
					   $last = ' <span class="disabled">Last >></span>'; // nor the last page link
					}
						
			
					if($maxPage > 1)
					{
						// print the navigation link
						$str = "<div class='pagination' align='center'><ul><table border=0 width=100%><tr><td align=left class='whitefont'>" . $pageNum ." of ".$maxPage." pages </td></tr></table> </ul>";
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

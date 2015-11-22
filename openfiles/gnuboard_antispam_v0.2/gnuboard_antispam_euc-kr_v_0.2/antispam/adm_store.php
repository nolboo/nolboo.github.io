<?php
	require_once("./_common.php");
	require_once("$base/admin.lib.php");
	$sub_menu = "405300";
	$g4['title'] = "스팸보관목록";
	require_once("$base/admin.head.php");

	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/js/adm_func.js");
	require_once("$base/antispam/util/Paging.php");
	require_once("$base/antispam/util/Strcut.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");	
auth_check($auth[$sub_menu], "r");

	$obj = new antispamAdminView();

	$list = $obj->dispBoardList();	//존재하는 모든 게시판
	$search_board = $obj->dispCurrentBoard($list);	//현재 게시판
	if( $search_board == false ){
		echo "$lang->no_board";
		return false;
	}

	$list_count = 15;	//한페이지에 표현되는 글 수
	$page_count = 10;
	$board_table = $obj->dispDocumentList($search_board, $list_count, $page_count, 'getStore'); //게시글 나열
//	$search_target = $board_table->search_target;
//	$search_keyword = $board_table->search_keyword->content;

$search_keyword =  "&search_content=$search_content&search_writer=$search_writer&search_ip=$search_ip&search_spam_score_more=$search_spam_score_more&search_spam_score_less=$search_spam_score_less&search_date_y_more=$search_date_y_more&search_date_m_more=$search_date_m_more&search_date_d_more=$search_date_d_more&search_date_y_less=$search_date_y_less&search_date_m_less=$search_date_m_less&search_date_d_less=$search_date_d_less";

	$search_content = $board_table->search_content;
	$search_writer = $board_table->search_writer;		
	$search_ip = $board_table->search_ip;
	$search_spam_score_more = $board_table->search_spam_score_more;
	$search_spam_score_less = $board_table->search_spam_score_less;
	
	$search_date_y_more = $board_table->search_date_y_more; 
	$search_date_m_more = $board_table->search_date_m_more; 
	$search_date_d_more = $board_table->search_date_d_more;
	$search_date_y_less = $board_table->search_date_y_less;
	$search_date_m_less = $board_table->search_date_m_less; 
	$search_date_d_less = $board_table->search_date_d_less;

	$colspan = 15;
//	$obj->deleteContent($search_board, $table_column->wr_id, 'deleteStore'); //지우기
?>

<?=subtitle("$lang->subtitle_store");?>

<table width=100% cellpadding=0 cellspacing=0 border=1>
<colgroup width=20% class='col1 pad1 bold'>
<tr><td>
&nbsp<?=$lang->help_store?>
</td></tr>
</table>
</br></br>


<form action="./adm_store.php" name="fsearch" method="get">
<table width=100% cellspacing=1 cellpadding=2 bgcolor="#EEEEEE">
<colgroup width=27%>
<colgroup width=26%>
<colgroup width=25%>
<colgroup width=24%>
<tr>
	<td>
			날짜 :
			<input type="text" name="search_date_y_more" value="<?=$search_date_y_more?>" style="width:45px" /> 년 
			<input type="text" name="search_date_m_more" value="<?=$search_date_m_more?>" style="width:30px" /> 월  
			<input type="text" name="search_date_d_more" value="<?=$search_date_d_more?>" style="width:30px" /> 일
	</td>
	<td>
			~ &nbsp&nbsp
			<input type="text" name="search_date_y_less" value="<?=$search_date_y_less?>" style="width:45px" /> 년 
			<input type="text" name="search_date_m_less" value="<?=$search_date_m_less?>" style="width:30px" /> 월 
			<input type="text" name="search_date_d_less" value="<?=$search_date_d_less?>" style="width:30px" /> 일
  	</td>
	<td>
			스팸지수 : <input type="text" name="search_spam_score_more" value="<?=$search_spam_score_more?>" style="width:30px" /> &nbsp ~ &nbsp
			<input type="text" name="search_spam_score_less" value="<?=$search_spam_score_less?>" style="width:30px" />
	</td>
	
	<td>
			게시판 : 
			<select id="search_board" style="width:120px;" onchange="changedSelect('search_board','<?=$_SERVER[PHP_SELF]?>')">
					<option value="<?=$search_board?>"><?=$search_board?></option>
			<?php if( sizeof($list->data)!=1 ) foreach($list->data as $bd ){ if( $bd->bo_table == $search_board ) continue; ?>				
					<option value="<?=$bd->bo_table?>"><?=$bd->bo_table?></option>
			<?php } ?>
			</select>
	</td>	
	
</tr>
<tr>
	<td>		
			내용 : <input type="text" name="search_content" value="<?=$search_content?>" style="width:160px"  />
    </td>
	<td>
            글쓴이 : <input type="text" name="search_writer" value="<?=$search_writer?>" style="width:137px"  />
	</td>
	<td>
			IP : <input type="text" name="search_ip" value="<?=$search_ip?>" style="width:130px"  />
	</td>
	<td align = center>
			<input type="image" src='<?=$g4[admin_path]?>/img/btn_search.gif' align=center value="<?=$lang->cmd_search?>" />			
	</td>
</tr>
</table>
<input type="hidden" name="search_board" value="<?=$search_board?>" />
</br>
<table width=100% >
<tr>
	<td align=left>
		Total <?=$board_table->total_count?>, Page <?=$board_table->page_navigation->cur_page?>/<?=$board_table->page_navigation->total_page?>
	</td>
	<td align=right>
		<!-- 선택 복원 / 선택 삭제 -->
		<button type="button" class='btn1' onclick="sendCheckBox('check', 'restore_content.php')"><?=$lang->sel_res?></button>
			
		<button type="button" class='btn1' onclick="sendCheckBox('check', 'delete_spam_contents.php')"><?=$lang->sel_del?></button>
	</td>
</tr>
</table>
</form>


<!-- 목록 -->
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=40px>
<colgroup width=20px>
<colgroup width=60px>
<colgroup width=''>
<colgroup width=60px>
<colgroup width=90px>
<colgroup width=120px>
<colgroup width=90px>
<thead>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
    <tr class='bgcol1 bold col1 ht center' >
		<? 
			$curURL = $_SERVER[PHP_SELF]."?page=".$board_table->page_navigation->cur_page."&search_board=$search_board$search_keyword";
		?>
		<td><a href="<?if( $order_by == "wr_datetime" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_datetime'.'&order='.$changedOrder?><?=$href?>"><?=$lang->no?></a></td>

        <td><input type="checkbox" id="checkBoxToggle" onclick="checkboxToggleAll('checkBoxToggle','check')" /></td>

        <td><a href="<?if( $order_by == "spam_score" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=spam_score'.'&order='.$changedOrder?><?=$href?>"><?=$lang->spamscore?></a></td>

        <td><a href="<?if( $order_by == "wr_content" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_content'.'&order='.$changedOrder?><?=$href?>"><?=$lang->document?></a></td>

        <td><a href="<?if( $order_by == "wr_is_comment" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_is_comment'.'&order='.$changedOrder?><?=$href?>"><?=$lang->document_type?></a></td>

        <td><a href="<?if( $order_by == "wr_name" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_name'.'&order='.$changedOrder?><?=$href?>"><?=$lang->nick_name?></a></td>

        <td><a href="<?if( $order_by == "wr_datetime" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_datetime'.'&order='.$changedOrder?><?=$href?>"><?=$lang->regdate?></a></td>

        <td><a href="<?if( $order_by == "wr_ip" ){if($order=="asc"){$changedOrder="desc";}else{$changedOrder="asc";}} $href=$curURL.'&order_by=wr_ip'.'&order='.$changedOrder?><?=$href?>"><?=$lang->ipaddress?></a></td>
	</tr>
</thead>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tbody>
	<?php $i=0; foreach( $board_table->data as $table_column){ ?>
    <tr class='list<?=$i%2?> col1 ht center'>
        <td><?=($board_table->total_count-(($board_table->page_navigation->cur_page-1)*$list_count))-$i ?></td>
        <td><input type="checkbox" value="<?=$table_column->wr_id?>" id="check" /></td>
		<td><?=$table_column->spam_score?></td>
       
		
		<td onClick="hideContent('hideContent<?=$i?>', 'shortContent<?=$i?>', 'longContent<?=$i?>')">
		<input type="hidden" id="hideContent<?=$i?>" value="off" />
		
		<a href=# onclick="return hideHref();">
		<div id="shortContent<?=$i?>" align="left">
		<?=strcut_utf8($table_column->wr_content, 40, true, "...");?>
		</div>

		<div id="longContent<?=$i?>" align="left">
		<?=$table_column->wr_content?>
		</div>
		</a>
		</td>
	

        <td><?if( 1 == $table_column->wr_is_comment ){?><?=$lang->reply?><?}else{?><?=$lang->document?><?}?></td>

        <td><?=$table_column->mb_id?></td>
        <td><?=$table_column->wr_datetime?></td>
        <td><?=$table_column->wr_ip?></td>
    </tr>
    <?php $i++; } if( $error == 1 ){ echo "<script>alert('".$lang->error_server."');</script>"; }

	if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>$lang->not_exist_contents</td></tr>";

	?>
	<script>initHideContent('longContent', '<?=$i?>');</script>
</tbody>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>

</form>

<!-- 페이지 네비게이션 -->
<div class="pagination a1" align="right">
	<?
	if( $order_by == null ){ $ordering = null; }
	else{ $ordering = "&order_by=$order_by&order=$order"; }
	?>
	<?=paging($board_table->page_navigation->cur_page, $board_table->page_navigation->total_page, $page_count, $board_table->page_navigation->total_count, "search_board=$search_board$search_keyword$ordering")?>
</div>
</body>
</html>

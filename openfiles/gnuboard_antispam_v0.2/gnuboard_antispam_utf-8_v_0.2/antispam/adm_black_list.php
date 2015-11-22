<?php
	require_once("./_common.php");
	require_once("$base/admin.lib.php");
	$sub_menu = "405500";
	$g4['title'] = "유저차단목록";
	require_once("$base/admin.head.php");

	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/js/adm_func.js");
	require_once("$base/antispam/util/Paging.php");
	require_once("$base/antispam/util/Strcut.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");	
auth_check($auth[$sub_menu], "r");



	$obj = new antispamAdminView();


	$list_count = 5;	//한페이지에 표현되는 글 수
	$page_count = 10;
	
	$sel=$_GET["search_board"];
	if( $sel == null ){
		$sel = "Id";
	}
	$board_table = $obj->dispDocumentList("getBlackList".$sel."Disp", $list_count, $page_count, "getBlackList"); //게시글 나열

	
	$colspan = 15;
?>

<?=subtitle("$lang->subtitle_black");?>

<table width=100% cellpadding=0 cellspacing=0 border=1>
<colgroup width=20% class='col1 pad1 bold'>
<tr><td>
&nbsp<?=$lang->help_black?>
</td></tr>
</table>
</br></br>


<table width=100%>
	<!-- 목록선택 -->
<td align=left>
		선택 : 
		<select id="search_board" style="width:280px;" onchange="changedSelect('search_board','<?=$_SERVER[PHP_SELF]?>')">
				<? if( $sel == "Id"  ) { ?>
					<option value="Id"><?=$lang->list_block_member?></option>
					<option value="Ip"><?=$lang->list_block_ip?></option>
				 <? } else{?>
					<option value="Ip"><?=$lang->list_block_ip?></option>
					<option value="Id"><?=$lang->list_block_member?></option>
				<? } ?>
		</select>
</td>
<tr>
	<td align=left>
		Total <?=$board_table->total_count?>, Page <?=$board_table->page_navigation->cur_page?>/<?=$board_table->page_navigation->total_page?>
	</td>
	<td align=right>
		<!-- 선택 삭제 -->
		<button type="button" class='btn1' onclick="sendCheckBox('check', 'delete_black_list.php')"><?=$lang->res_spammer?></button>
	</td>
</tr>
</table>

<!-- 목록 -->
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=40px>
<colgroup width=20px>
<colgroup width=60px>
<colgroup width=80px>
<colgroup width=60px>
<colgroup width=60px>
<colgroup width=''>
<colgroup width=120px>
<colgroup width=40px>
<thead>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
    <tr class='bgcol1 bold col1 ht center' >
        <td><?=$lang->no?></div></td>
        <td><input type="checkbox" id="checkBoxToggle" onclick="checkboxToggleAll('checkBoxToggle','check')" /></div></td>
		<td><?=$lang->manage?></td>
		<td><?=$lang->id?></td>
        <td><?=$lang->ipaddress?></td>
        <td><?=$lang->spamscore?></td>
        <td><?=$lang->document?></td>
        <td><?=$lang->regdate?></td>
		<td><?=$lang->try_write_spam?></td>
    </tr>
</thead>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tbody>
	<?php $i=0; foreach( $board_table->data as $table_column){ ?>
    <tr class='list<?=$i%2?> col1 ht center'>
        <td><?=($board_table->total_count-(($board_table->page_navigation->cur_page-1)*$list_count))-$i ?></td>
        <td><input type="checkbox" value="<? if( $sel == 'Id' ) { ?><?=$table_column->user_id?><? } else {?><?=$table_column->user_ip?><?}?>" id="check" class="check_content_srl" /></td>
		<td><? if( $sel == 'Id' ) { ?><?=$lang->block_member?><? } else {?><?=$lang->block_ip?><?}?></td>
		<td><? if( $table_column->user_id=="" ){ ?>Guest<? } else { ?><?=$table_column->user_id?><?}?></td>
		<td><?=$table_column->user_ip?></td>
		<td><?=$table_column->spam_score?></td>
        
		<td onClick="hideContent('hideContent<?=$i?>', 'shortContent<?=$i?>', 'longContent<?=$i?>')">
		<input type="hidden" id="hideContent<?=$i?>" value="off" />		
			<a href=# onclick="return hideHref();">
			<div id="shortContent<?=$i?>" align="left">
			<?=strcut_utf8($table_column->content, 45, true, "...");?>
			</div>

			<div id="longContent<?=$i?>" align="left">
			<?=$table_column->content?>
			</div>
			</a>
		</td>

        <td><?=$table_column->datetime?></td>
		<td><?=$table_column->try_write_spam?></td>
    </tr>
    <?php $i++; }  if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>$lang->not_exist_contents</td></tr>";
	?>
	<script>initHideContent('longContent', '<?=$i?>');</script>
</tbody>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>

</form>

<!-- 페이지 네비게이션 -->
<div class="pagination a1" align="right">
	<?=paging($board_table->page_navigation->cur_page, $board_table->page_navigation->total_page, $page_count, $board_table->page_navigation->total_count,  "search_board=$sel")?>
</div>
</body>
</html>

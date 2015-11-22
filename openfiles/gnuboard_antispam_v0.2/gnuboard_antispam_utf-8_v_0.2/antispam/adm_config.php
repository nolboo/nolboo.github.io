<?php 
	require_once("./_common.php");
	require_once("$base/admin.lib.php");
	$sub_menu = "405100";
	$g4['title'] = "설정";
	require_once("$base/admin.head.php");


	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/js/adm_func.js");
	require_once("$base/antispam/util/Paging.php");
	require_once("$base/antispam/util/Strcut.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");	


auth_check($auth[$sub_menu], "r");


	$obj = new antispamAdminView();
	$config = $obj->dispantispamAdminConfig();


	///
$fp = @fsockopen('antispam.spamcop.or.kr', '8406', $errno, $errstr, 5);
if(!$fp) return false;

//while(trim($buffer = fgets($fp,1024)) != "");

$data = "";
while(!feof($fp)) {
	$data .= trim(fgets($fp, 4096));
}
fclose($fp);
///


//버전업

$updateVersion = "";

$arr = split(":",$data);

$i=0;
foreach ($arr as $board){
	if($arr[$i]=="Gnuboard"){
		$updateVersion=$arr[$i+1];
	}
	$i++;
}

$subtitle="";





if($updateVersion!=$lang->version){

	$lang->subtitle_config = $lang->subtitle_config."&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://spam.kisa.or.kr/' target='_blank'><img src='icn_new.gif' boder='0'>&nbsp;<font color='red'>".$updateVersion."&nbsp;Version</font></a>";
	$subtitle = subtitle("$lang->subtitle_config");

} else {

	$subtitle = subtitle("$lang->subtitle_config");
}


?>


<?=$subtitle?>

<table width=100% cellpadding=0 cellspacing=0 border=1>
<colgroup width=20% class='col1 pad1 bold'>
<tr><td>
&nbsp<?=$lang->help_config?>
<div align=center color=red><font color="red"><?=$lang->help_user?></font></div>
</td></tr>
</table>
</br></br>


<form action="">
<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=20% class='col1 pad1 bold'>
<colgroup width=80% class='col2 pad2'>
<tr><td colspan=4 class=line1></td></tr>
	<tbody>
	<!-- 스팸차단 설정 -->

	<tr class='ht'>
		<td><?=$lang->use_antispam?></td>

		<td>
			<!-- 스팸차단 설정 체크박스 -->
			<?=$lang->using?>
			
			<input type="checkbox" id="use_antispam" onclick="clickConfigCheckbox('use_antispam', 'score_antispam', '<?=$lang->score_antispam_default?>')" <?php if($config->data->use_antispam=='Y'){ ?>checked="ckecked" value="Y" <?php } else { ?> value="N" <?php  } ?> />

			<!-- 스팸차단 설정 텍스트박스 -->
			- <?=$lang->about_use_antispam_a?>
		
			<input type="text" id="score_antispam" maxlength="3" size="3" class="inputTypeText"  <?php if($config->data->use_antispam=='Y'){ ?>value=<?=$config->data->score_antispam?><?php }  ?> />
			<?=$lang->about_use_antispam_b?>
</a>
		</td>
	</tr>
<tr><td colspan=4 class=line2></td></tr>
	<!-- 차단메세지 설정 -->
	<tr class='ht'>
		<td>관리자 연락처 설정</td>
		<td>
			연락처 : 
			<!-- 차단메세지 설정 텍스트박스 -->
			<input type="text" id="phone1" maxlength="5" size="5" value=<?=$config->data->phone1?> > - 
			<input type="text" id="phone2" maxlength="5" size="5" class="inputTypeText" value=<?=$config->data->phone2?> > - 
			<input type="text" id="phone3" maxlength="5" size="5" class="inputTypeText" value=<?=$config->data->phone3?> >
			<br />
			이메일 :
			<input type="text" id="mail1" maxlength="30" size="15" class="inputTypeText" value=<?=$config->data->mail1?> > @ 
			<input type="text" id="mail2" maxlength="20" size="10" class="inputTypeText" value=<?=$config->data->mail2?> > . 
			<input type="text" id="mail3" maxlength="20" size="10" class="inputTypeText" value=<?=$config->data->mail3?> >
</a>
		</td>
	</tr>
<tr><td colspan=4 class=line2></td></tr>
	<!-- 계정차단 설정 -->
	<tr class='ht'>
		<td><?=$lang->use_block_member?></td>
		<td>
			<!-- 계정차단 설정 체크박스 -->
			<?=$lang->using?>
					
			<input type="checkbox" id="use_block_member" onclick="clickConfigCheckbox('use_block_member', 'score_block_member', '<?=$lang->score_block_default?>', 'date_block_member', '<?=$lang->date_block_default?>')" <?php if($config->data->use_block_member=='Y'){ ?>checked="ckecked" value="Y" <?php } else { ?> value="N" <?php  } ?> />

			<!-- 계정차단 설정 텍스트박스 -->
			- <?=$lang->about_use_block_a?> 

			<input type="text" id="score_block_member" maxlength="3" size="3" class="inputTypeText"  <?php if($config->data->use_block_member=='Y'){ ?>value=<?=$config->data->score_block_member?><?php } ?> />
			
			<?=$lang->about_use_block_member?>
			<?=$lang->about_date_block_a?>

			<input type="text" id="date_block_member" maxlength="3" size="3" class="inputTypeText"  <?php if($config->data->use_block_member=='Y'){ ?>value=<?=$config->data->date_block_member?><?php } ?> />

			<?=$lang->about_date_block_b?>

		</td>
	</tr>
<tr><td colspan=4 class=line2></td></tr>
	<!-- IP차단 설정 -->
	<tr class='ht'>
		<td><?=$lang->use_block_ip?></td>
		<td>
			<!-- IP차단 설정 체크박스 -->
			<?=$lang->using?>
					
			<input type="checkbox" id="use_block_ip" onclick="clickConfigCheckbox('use_block_ip', 'score_block_ip', '<?=$lang->score_block_default?>', 'date_block_ip', '<?=$lang->date_block_default?>')" <?php if($config->data->use_block_ip=='Y'){ ?>checked="ckecked" value="Y" <?php } else { ?> value="N" <?php  } ?> />

			<!-- IP차단 설정 텍스트박스 -->
			- <?=$lang->about_use_block_a?> 

			<input type="text" id="score_block_ip" maxlength="3" size="3" class="inputTypeText"  <?php if($config->data->use_block_ip=='Y'){ ?>value=<?=$config->data->score_block_ip?><?php } ?> />
			
			<?=$lang->about_use_block_ip?>
			<?=$lang->about_date_block_a?>

			<input type="text" id="date_block_ip" maxlength="3" size="3" class="inputTypeText"  <?php if($config->data->use_block_ip=='Y'){ ?>value=<?=$config->data->date_block_ip?><?php } ?> />

			<?=$lang->about_date_block_b?>
		</td>
	</tr>
<tr><td colspan=4 class=line2></td></tr>
	<!-- 예외단어 등록 -->
	<tr class='ht'>
		<td><?=$lang->except_word?></td>
		<td>
			<p><?=$lang->about_except_word?></p>
			
			<!-- 예외단어 입력 -->
			<input type="text" id="except_word" maxlength="19" size="19" />
			
			<button type="button" class='btn1' onclick="insertSelected('exception_word_list', 'except_word', 'except_word')"><?=$lang->enter?></button>
			</p>
			
			<!-- 예외단어 목록 -->
			<select id="exception_word_list" size="5" style="width:200px" class="selected">
				<?php $exception_word_list = array();
					  $exception_word_list = unserialize($config->data->exception_word_list);
					
					foreach($exception_word_list as $exception_word) { if( strlen($exception_word) > 0 ){ ?>
					<option value="<?=$exception_word?>"><?=$exception_word?></option>
				<?php  }} ?>
			</select>
			</br>
			
			<!-- 예외단어 삭제 -->
			<button type="button" class='btn1' onclick="midRemove('exception_word_list')"><?=$lang->del?></button>
		</td>
	</tr>
<tr><td colspan=4 class=line2></td></tr>
	<!-- 스팸판단 테스트 -->
	<tr class='ht'>
		<td><?=$lang->test_spam?></td>
		<td>
			<p><?=$lang->about_test_spam?></p>
			<textarea id="test_content" rows="6" cols="80"></textarea>
			<br />
			<button type="button" class='btn1' onclick="testGetSpamScore()"><?=$lang->check_spam?></button>
		</td>
	</tr>
	</tbody>
<tr><td colspan=4 class=line1></td></tr>
	<!-- 설정 저장 -->
	<tfoot>
		<td colspan="2"><center>
		<button type="button" class='btn1' onclick="InsertAdmConfig();"><?=$lang->enter?></button>
		</center></td>
	</tfoot>
</table>
</form>
</body>
</html>

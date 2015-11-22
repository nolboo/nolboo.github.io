
<?  
	require_once("./_common.php");
	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/libs/RequestGetSpamScores.class.php");

?>

<script type="text/javascript" src="<?=$base?>/antispam/js/jquery-1.6.4.js"></script>


<script>
//////////////////////////////////////////////////////////////////////////////
function syncMid(id) {
    var sel_obj = jQuery('#'+id).get(0);
    var valueArray = [];
    for(var i=0;i<sel_obj.options.length;i++) valueArray.push(sel_obj.options[i].value);
	jQuery('#'+id).val(valueArray.join(','));
}
//////////////////////////////////////////////////////////////////////////////
function midRemove(id) {

	var sel_obj = jQuery('#'+id).get(0);
    if(sel_obj.selectedIndex<0) return;
    var idx = sel_obj.selectedIndex;
    sel_obj.remove(idx);
    idx = idx-1;
    if(idx < 0) idx = 0;
    if(sel_obj.options.length) sel_obj.selectedIndex = idx;

    syncMid(id);
}
//////////////////////////////////////////////////////////////////////////////
function insertSelected(target, val, text) {
	var sel_obj = jQuery('#'+target).get(0);
	val = jQuery('#'+ val).val();
	text = jQuery('#'+ text).val();

	if( val == "" && text == "" ) return;

    for(var i=0;i<sel_obj.options.length;i++) if(sel_obj.options[i].value==val) return;
    var opt = new Option(text, val, false, false);
    sel_obj.options[sel_obj.options.length] = opt;
    if(sel_obj.options.length>8) sel_obj.size = sel_obj.options.length;

   syncMid(target);
}

//////////////////////////////////////////////////////////////////////////////
function changedSelect(id, url){
	
	document.location.href=url+"?"+id+"="+ jQuery("#"+id).val();

}

//////////////////////////////////////////////////////////////////////////////
function checkboxToggleAll(id, targetId){
	
	isChecked = jQuery("#"+id).attr('checked');
	jQuery("input:checkbox").each(function(){
		if( isChecked )	$("input:checkbox[id="+targetId+"]").attr('checked', 'checked');
		else $("input:checkbox[id="+targetId+"]").removeAttr('checked');
		}
	)

}

//////////////////////////////////////////////////////////////////////////////
function clickConfigCheckbox(id, textId, text, textId2, text2){

	if( "N" == jQuery('#'+id).val() ){
		jQuery('#'+id).val("Y");
		jQuery('#'+textId).val(text);
		jQuery('#'+textId2).val(text2);
	}
	else{
		jQuery('#'+id).val("N");
		//jQuery('#'+textId).val();
	}
}
//////////////////////////////////////////////////////////////////////////////
function InsertAdmConfig(){
	
	/* 설정 된 값 */
	var use_antispam = jQuery('#use_antispam').val();
	var	score_antispam = jQuery('#score_antispam').val();
	var phone1 = jQuery('#phone1').val();
	var phone2 = jQuery('#phone2').val();
	var phone3 = jQuery('#phone3').val();
	var mail1 = jQuery('#mail1').val();
	var mail2 = jQuery('#mail2').val();
	var mail3 = jQuery('#mail3').val();
	var	use_block_member = jQuery('#use_block_member').val();	
	var	use_block_ip = jQuery('#use_block_ip').val();	
	var	score_block_member = jQuery('#score_block_member').val();
	var	score_block_ip = jQuery('#score_block_ip').val();
	var	date_block_member = jQuery('#date_block_member').val();
	var	date_block_ip = jQuery('#date_block_ip').val();
	var	exception_word_list = getSelectBoxInfo(jQuery('#exception_word_list').get(0));

	/* 예외 처리 */
	if( "Y" == use_antispam ){
		if( !( 0 < parseInt(score_antispam) && 100 >= parseInt(score_antispam)) ){
			alert("<?=$lang->exception_incorrect_spam_score?>");
			return 0;
		}
	}

	if( "Y" == use_block_member ){
		if( !( 0 < parseInt(score_block_member) && 999 >= parseInt(score_block_member)) ){
			alert("<?=$lang->exception_incorrect_block_member_score?>");
			return 0;
		}

		if( !( 0 < parseInt(date_block_member) && 999 >= parseInt(date_block_member)) ){
			alert("<?=$lang->exception_incorrect_block_ip_score?>");
			return 0;
		}
	}


	if( "Y" == use_block_ip ){
		if( !( 0 < parseInt(score_block_ip) && 999 >= parseInt(score_block_ip)) ){
			alert("<?=$lang->exception_incorrect_block_ip_score?>");
			return 0;
		}

		if( !( 0 < parseInt(date_block_ip) && 999 >= parseInt(date_block_ip)) ){
			alert("<?=$lang->exception_incorrect_block_ip_score?>");
			return 0;
		}
	}

	
	var address = document.URL.replace(/&/gi, '|@|');
	var data = "use_antispam="+use_antispam+"&"+
			"score_antispam="+score_antispam+"&"+
			"phone1="+phone1+"&"+
			"phone2="+phone2+"&"+
			"phone3="+phone3+"&"+
			"mail1="+mail1+"&"+
			"mail2="+mail2+"&"+
			"mail3="+mail3+"&"+
			"use_block_member="+use_block_member+"&"+
			"use_block_ip="+use_block_ip+"&"+
			"score_block_member="+score_block_member+"&"+
			"score_block_ip="+score_block_ip+"&"+
			"date_block_member="+date_block_member+"&"+
			"date_block_ip="+date_block_ip+"&"+
			"exception_word_list="+exception_word_list+"&"+
			"address="+address;

	document.location.href = 'update_adm_config.php?'+data;


	return 0;
}

//////////////////////////////////////////////////////////////////////////////
function getSelectBoxInfo(obj){
	var info = [];
	var str;
    for(var i=0;i<obj.options.length;i++){
		str = obj.options[i].text;
		if( str.length > 0 ){
			info.push(str);
		}
	}
	return  encodeURIComponent(info.join('|@|'));
}



//////////////////////////////////////////////////////////////////////////////
function testGetSpamScore(){
	var content = jQuery('#test_content').val();
	var use_antispam = jQuery('#use_antispam').val();
	var	score_antispam = jQuery('#score_antispam').val();
	var	exception_word_list = getSelectBoxInfo(jQuery('#exception_word_list').get(0));

	/* 예외 처리 */
	if ( "" == content)
	{
		alert("<?=$lang->exception_not_exist_text?>");
		return 0;
	}
	if( "Y" == use_antispam ){
		if( !( 0 < parseInt(score_antispam) && 100 >= parseInt(score_antispam)) ){
			alert("<?=$lang->exception_incorrect_spam_score?>");
			return 0;
		}
	}

	content = encodeURIComponent(content);

	var address = document.URL.replace(/&/gi, '|@|');
	var data = 	"content="+content+"&"+
			"use_antispam="+use_antispam+"&"+
			"score_antispam="+score_antispam+"&"+
			"exception_word_list="+exception_word_list+"&"+
			"address="+address;

	document.location.href = 'get_test_result.php?'+data;


}

//////////////////////////////////////////////////////////////////////////////

function sendCheckBox(id, targetUrl){

	var isChecked = false;
	var checkedList = [];
	var content_id;

	jQuery("input:checkbox[id="+id+"]").each(function(){
		if( jQuery(this).attr('checked') == "checked" ){
			content_id = $(this).val();
			checkedList.push(content_id);
			isChecked = true;
		}
	})
	if( !isChecked ){
		alert("<?=$lang->exception_not_exist_check?>");
		return 0;
	}

	var checks =  encodeURIComponent(checkedList.join('|@|'));
	var board = jQuery("#search_board").val();
	
	var address = document.URL.replace(/&/gi, '|@|');
	var data = "check_list="+checks+"&"+
			"board="+board+"&"+
			"address="+address;

	document.location.href = targetUrl+"?"+data;

}

//////////////////////////////////////////////////////////////////////////////
function hideContent(hideId, shortId, longId){
	

	if( jQuery("#"+hideId).val() == "on" ){
		jQuery("#"+longId).hide();
		jQuery("#"+shortId).show();
		jQuery("#"+hideId).val("off");
	}else if( jQuery("#"+hideId).val() == "off" ){
		jQuery("#"+longId).show();
		jQuery("#"+shortId).hide();
		jQuery("#"+hideId).val("on");
	}
	
}

//////////////////////////////////////////////////////////////////////////////
function initHideContent(id, count){
	var i=0;
	for( i=0; i<count; i++ ){
		jQuery("#"+id+i).hide();
	}
}
//////////////////////////////////////////////////////////////////////////////
function hideHref(){
	return false;
}


</script>

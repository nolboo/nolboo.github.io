<?php
	require_once("./_common.php");	
	require_once("$base/admin.lib.php");
	require_once("$base/../head.sub.php");
	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");


	$obj = new antispamAdminView();
	$result = $obj->dispantispamAdminTestGetSpamScore();

	if( $result->result == 0 ){
		//일반글
		echo "<script>alert('$lang->alert_test_is_not_spam$result->score');</script>";
	}else if ( $result->result == 1){
		//스팸글
		echo "<script>alert('$lang->alert_test_is_spam$result->score');</script>";
	}else{
		//error
		echo "<script>alert('$lang->error_server');</script>";
	}

	$address = $_GET["address"];
	$address = str_replace("|@|","&", $address);
	echo "<script>document.location.href = '$address';</script>";

?>

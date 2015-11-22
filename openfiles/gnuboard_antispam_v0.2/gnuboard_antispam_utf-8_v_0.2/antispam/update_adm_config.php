<?php
	require_once("./_common.php");
	require_once("$base/admin.lib.php");
	require_once("$base/../head.sub.php");
	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");


	$obj = new antispamAdminView();
	$result = $obj->dispantispamAdminConfigUpdate();

	
	if( $result == 1 ) echo "<script>alert('$lang->update_adm_config_success');</script>";
	else echo "<script>alert('$lang->fail');</script>";
	
	$address = $_GET["address"];
	$address = str_replace("|@|","&", $address);
	echo "<script>document.location.href = '$address';</script>";
?>
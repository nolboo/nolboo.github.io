<?php
	require_once("./_common.php");
	require_once("$base/admin.lib.php");
	require_once("$base/../head.sub.php");
	require_once("$base/antispam/lang/lang.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");

	$obj = new antispamAdminView();
	$result = $obj->sendSpamContents();
	
	if( $result == 1 ) echo "<script>alert('$lang->send_content_success');</script>";
	else echo "<script>alert('$lang->fail');</script>";

	echo "<script>window.open('https://minwon.spamcop.or.kr/h_singo/singo_homepage.jsp?type=7','new');</script>";

	$address = $_GET["address"];
	$address = str_replace("|@|","&", $address);
	echo "<script>document.location.href = '$address';</script>";
?> 
<?php
	require_once("./_common.php");
	require_once("$base/../head.sub.php");
	require_once("$base/../dbconfig.php");
	require_once("$base/antispam/util/FileHandler.class.php");
	require_once("$base/antispam/lang/lang.php");

	require_once("$base/admin.lib.php");

	/* DB정보 입력 */
	$buf = 
"<?php 
\$db_info->db_hostname = '$mysql_host';
\$db_info->db_userid = '$mysql_user';
\$db_info->db_password = '$mysql_password';
\$db_info->db_database = '$mysql_db';

\$db_info->db_type = 'mysql';
\$db_info->db_port = '3306';
\$db_info->db_table_prefix = 'g4';
?>";

	FileHandler::writeFile("$base/antispam/db/db.config.php", $buf);

	require_once("$base/antispam/db/DB.class.php");
	require_once("$base/antispam/classes/antispam.admin.view.php");


	/* 설정 저장을 위한 테이블 생성 */
	$oDB = &DB::getInstance();
	if (!$oDB->isTableExists("antispam_adm_config")){		
		$oDB->createTableByXmlFile("$base/antispam/schemas/antispam_adm_config.xml");

		$args->use_antispam = 'Y';
		$args->score_antispam = $lang->score_antispam_default;

		$args->use_block_member = 'N';
		$args->use_block_ip = 'N';
		$args->exception_word_list = '#init';
		$oDB->executeQuery('antispam.insertAdmConfig', $args);
	}

	/* 전화번호, 이메일추가 */
	$oDB->addColumn("antispam_adm_config", "phone1", "varchar", "5", "0", "0");
	$oDB->addColumn("antispam_adm_config", "phone2", "varchar", "5", "0", "0");
	$oDB->addColumn("antispam_adm_config", "phone3", "varchar", "5", "0", "0");
	$oDB->addColumn("antispam_adm_config", "mail1", "varchar", "30", "0", "0");
	$oDB->addColumn("antispam_adm_config", "mail2", "varchar", "30", "0", "0");
	$oDB->addColumn("antispam_adm_config", "mail3", "varchar", "30", "0", "0");

	
	/* 스팸 보관을 위한 테이블 생성 */
	if (!$oDB->isTableExists("antispam_store")){		
		$oDB->createTableByXmlFile("$base/antispam/schemas/antispam_store.xml");
	}

	/* 스패머 관리를 위한 테이블 생성(id) */
	if (!$oDB->isTableExists("antispam_spammer_id")){		
		$oDB->createTableByXmlFile("$base/antispam/schemas/antispam_spammer_id.xml");
	}

	/* 스패머 관리를 위한 테이블 생성(ip) */
	if (!$oDB->isTableExists("antispam_spammer_ip")){		
		$oDB->createTableByXmlFile("$base/antispam/schemas/antispam_spammer_ip.xml");
	}

	/* 스팸로그를 위한 테이블 생성 */
	if (!$oDB->isTableExists("antispam_log")){		
		$oDB->createTableByXmlFile("$base/antispam/schemas/antispam_log.xml");
	}

	/* 스패머 차단을 위한 컬럼 추가 */
	//$oDB->addColumn("member", "mb_spammer", "number", "4", "0", "0");

	/* 모든 게시판에 스팸관련 컬럼 추가 */
	$obj = new antispamAdminView();
	$list = $obj->dispBoardList();	//존재하는 모든 게시판

	//컬럼추가
	/*
	if( $list->data == null ){
		//게시판존재하지 않음
	}
	else if(sizeof($list->data) == 1){
		$board = $list->data->bo_table;
		
		$oDB->addColumn("write_".$board, "spam_score", "number", "11", "0", "0");
		$oDB->addColumn("write_".$board, "spam_type", "varchar", "10", "0", "0");
		$oDB->addColumn("write_".$board, "wr_spam_config_regdate", "date", "0", "0", "0");
	}
	else{
		foreach( $list->data as $bd ){
			$board = $bd->bo_table;
		
			$oDB->addColumn("write_".$board, "spam_score", "number", "11", "0", "0");
			$oDB->addColumn("write_".$board, "spam_type", "varchar", "10", "0", "0");
			$oDB->addColumn("write_".$board, "wr_spam_config_regdate", "date", "0", "0", "0");
		}
	}
	*/


	/* 글 입력 부분 삽입 */
	$buf=FileHandler::readFile("$base/../bbs/write_update.php");
if( strpos($buf, "isSpam")  === false ){

	$buf = str_replace( "include_once(\"./_common.php\");", "include_once(\"./_common.php\");
include_once(\"\$g4[admin_path]/antispam/antispam_trigger.php\");", $buf );

	$buf = str_replace( "\$wr_reply = \"\";", "\$wr_reply = \"\";
	}
	if( true == isSpam(\$mb_id, \$_SERVER[REMOTE_ADDR], \$wr_content, \$wr_subject) ){
		return false;", $buf);

	$buf = str_replace( "\$sql_ip = \" , wr_ip = '\$_SERVER[REMOTE_ADDR]' \";", "\$sql_ip = \" , wr_ip = '\$_SERVER[REMOTE_ADDR]' \";
	if( true == isSpam(\$mb_id, \$_SERVER[REMOTE_ADDR], \$wr_content, \$wr_subject) ){
		return false;
	}", $buf);
	
	FileHandler::writeFile("$base/../bbs/write_update.php", $buf);	
}
	/* 댓글 입력 부분 삽입 */
	$buf=FileHandler::readFile("$base/../bbs/write_comment_update.php");
if( strpos($buf, "isSpam")  === false ){
	$buf = str_replace( "include_once(\"./_common.php\");", "include_once(\"./_common.php\");
include_once(\"\$g4[admin_path]/antispam/antispam_trigger.php\");", $buf );

	$buf = str_replace( "\$tmp_comment_reply = \"\";", "\$tmp_comment_reply = \"\";
	}
	if( true == isSpam(\$mb_id, \$_SERVER[REMOTE_ADDR], \$wr_content, \$wr_subject) ){
		return false;", $buf);

	$buf = str_replace( "\$sql_secret = \" , wr_option = '\$wr_secret' \";", "\$sql_secret = \" , wr_option = '\$wr_secret' \";
	if( true == isSpam(\$mb_id, \$_SERVER[REMOTE_ADDR], \$wr_content, \$wr_subject) ){
		return false;
	}", $buf);

	FileHandler::writeFile("$base/../bbs/write_comment_update.php", $buf);
}



	/* 관리자페이지에 메뉴 삽입 */
	$buf=FileHandler::readFile("$base/antispam/install/admin.menu405.php");
	FileHandler::writeFile("$base/admin.menu405.php", $buf);

	$buf=FileHandler::readFile("$base/antispam/install/img/menu405.gif");
	FileHandler::writeFile("$base/img/menu405.gif", $buf);

	$buf=FileHandler::readFile("$base/antispam/install/img/title_menu405.gif");
	FileHandler::writeFile("$base/img/title_menu405.gif", $buf);
	

	//캐시지우기
	$path="$base/antispam/db/cache/";
	$dir = opendir($path);
	while ($file = readdir($dir))
	{
		if( $file!="." && $file!=".." )
		{
			unlink($path."/".$file);
		}
	}
	closedir($dir);


	echo"<script>
		document.location.href = '$base/antispam/adm_config.php';
		alert('$lang->install_complete');
		 </script>";



?>
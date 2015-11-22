<?php

	require_once("./_common.php");
	require_once("$base/antispam/db/DB.class.php");

	class antispamModel{

		/* 스팸 정책 설정 DB에 저장 */
		function setantispamAdminConfig($args) {
			$oDB = &DB::getInstance();
		    $output = $oDB->executeQuery('antispam.deleteAdmConfig', $args);
			if(!$output) return $output;
            $output = $oDB->executeQuery('antispam.insertAdmConfig', $args);
            return $output;
		}
		
		/* xml로 DB와 통신 */
		function getDBbyXML($xml, $args=null){
			$oDB = &DB::getInstance();
			return $oDB->executeQuery($xml, $args);
		}

		/* 컬럼추가 */
		function addColumn($table, $field, $type, $size){
			$oDB = &DB::getInstance();
			return $oDB->addColumn($table, $field, $type, $size, "0", "0");
		}

	}
?>

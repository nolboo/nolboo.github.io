<?php
	require_once("./_common.php");
	require_once("$base/antispam/classes/antispam.admin.controller.php");
	require_once("$base/antispam/classes/antispam.model.php");

	class antispamAdminView{

		/* 스팸 정책 설정 값 입력, 결과 출력 */
		function dispantispamAdminConfigUpdate() {
			$params->use_antispam = $_GET["use_antispam"];
			$params->score_antispam = $_GET["score_antispam"];
			$params->phone1 = $_GET["phone1"];
			$params->phone2 = $_GET["phone2"];
			$params->phone3 = $_GET["phone3"];
			$params->mail1 = $_GET["mail1"];
			$params->mail2 = $_GET["mail2"];
			$params->mail3 = $_GET["mail3"];
			$params->use_block_member = $_GET["use_block_member"];
			$params->use_block_ip = $_GET["use_block_ip"];
			$params->score_block_member = $_GET["score_block_member"];
			$params->score_block_ip = $_GET["score_block_ip"];
			$params->date_block_member = $_GET["date_block_member"];
			$params->date_block_ip = $_GET["date_block_ip"];
			$params->exception_word_list = $_GET["exception_word_list"];


/* 예외처리 */
if( $params->use_antispam != "Y" && $params->use_antispam != "N" ) return;
if( $params->use_block_member != "Y" && $params->use_block_member != "N" ) return;
if( $params->use_block_ip != "Y" && $params->use_block_ip != "N" ) return;
if( $params->use_antispam == "Y" ) if( !($params->score_antispam > 0 && $params->score_antispam <= 100) ) return;
if( $params->use_block_member == "Y" ) if( !($params->score_block_member > 0 && $params->score_block_member <= 999) ) return;
if( $params->use_block_ip == "Y" ) if( !($params->score_block_ip > 0 && $params->score_block_ip <= 999) ) return;
if( $params->use_block_member == "Y" ) if( !($params->date_block_member > 0 && $params->date_block_member <= 999) ) return;
if( $params->use_block_ip == "Y" ) if( !($params->date_block_ip > 0 && $params->date_block_ip <= 999) ) return;


			$obj = new antispamAdminController();
			return $obj->procantispamAdminConfigUpdate($params);	
		}

		/* 체크 된 글에 스팸정책 적용 */
		function applySpamConfig() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];
			$obj = new antispamAdminController();
			return $obj->applySpamConfig($check_list,$board);	
		}


		/* 신고된 글 처리 */
		function sendSpamContents() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];

			$obj = new antispamAdminController();
			return $obj->sendSpamContents($check_list,$board);	
		}

		/* 스팸보관함에 있는 글 삭제 */
		function deleteSpamcontents() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];

			$obj = new antispamAdminController();
			return $obj->deleteSpamcontents($check_list,$board);	
		}


		/* 스팸로그 글 삭제 */
		function deleteLog() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];

			$obj = new antispamAdminController();
			return $obj->deleteLog($check_list,$board);	
		}


		/* 체크 된 글 복원 */
		function restoreContent() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];

			$obj = new antispamAdminController();
			return $obj->restoreContent($check_list,$board);	
		}
		
		/* 차단 조치 해제 */
		function deleteBlackList() {
			$check_list = $_GET["check_list"];
			$board = $_GET["board"];

			$obj = new antispamAdminController();
			return $obj->deleteBlackList($check_list,$board);	
		}



		/* 스팸 정책 설정 값 가져오기 */
		function dispantispamAdminConfig() {
			$obj = new antispamModel();
			return $obj->getDBbyXML('antispam.getAdmConfig');
		}



		/* 스팸지수 산출 테스트, 결과 출력*/
		function dispantispamAdminTestGetSpamScore() {
			$test->exception_word_list = array();
			$test->exception_word_list = explode('|@|',$_GET["exception_word_list"]);
			$test->content = $_GET["content"];
			
			$obj = new antispamAdminController();
			$result = $obj->procGetSpamScore($test->content, $test->exception_word_list);
			

			$use_antispam = $_GET["use_antispam"];
			$score_antispam = $_GET["score_antispam"];
			return $obj->getTestResult($result->score, $result->type,$use_antispam, $score_antispam);
		}
		
		/* 존재하는 모든 게시판 출력 */
		function dispBoardList(){
			$obj = new antispamModel();
			return $obj->getDBbyXML('antispam.getDocumentList');
		}

		/* 현재 게시판의 종류 출력 */
		function dispCurrentBoard($list){
			$obj = new antispamAdminController();
			return $obj->checkCurrentBoard( $_GET["search_board"], $list );
		}				

		/* 게시판의 글 출력 */
		function dispDocumentList($search_board, $list_count='20', $page_count='10', $func='0', $orderBy='wr_datetime',  $order='desc'){
			//현재페이지
			$page = $_GET["page"];
			// 검색 조건 세팅
			$search_keyword->search_content =  $_GET["search_content"];
			//$search_keyword->search_type =  $_GET["search_type"];
			$search_keyword->search_writer =  $_GET["search_writer"];
			$search_keyword->search_ip =  $_GET["search_ip"];
			
			$search_keyword->search_spam_score_more = ( $_GET["search_spam_score_more"] != null ) ? $_GET["search_spam_score_more"] : 0;
			$search_keyword->search_spam_score_less = ( $_GET["search_spam_score_less"] != null ) ? $_GET["search_spam_score_less"] : 100;

			
			$search_keyword->search_date_y_less = $search_date_y_less = ( $_GET["search_date_y_less"] != null ) ? $_GET["search_date_y_less"] : DATE("Y",time());
			$search_keyword->search_date_y_more = $search_date_y_more = ( $_GET["search_date_y_more"] != null ) ? $_GET["search_date_y_more"] : $search_date_y_less-10;

			$search_keyword->search_date_m_less = $search_date_m_less = ( $_GET["search_date_m_less"] != null ) ? $_GET["search_date_m_less"] : DATE("m",time());
			$search_keyword->search_date_m_more = $search_date_m_more = ( $_GET["search_date_m_more"] != null ) ? $_GET["search_date_m_more"] : $search_date_m_less;

			$search_keyword->search_date_d_less = $search_date_d_less = ( $_GET["search_date_d_less"] != null ) ? $_GET["search_date_d_less"] : DATE("d",time());
			$search_keyword->search_date_d_more = $search_date_d_more = ( $_GET["search_date_d_more"] != null ) ? $_GET["search_date_d_more"] : $search_date_d_less;
			$search_date_d_less = $search_keyword->search_date_d_less+1;

			if( strlen($search_date_m_more) == 1 ) $search_date_m_more = "0".$search_date_m_more;
			if( strlen($search_date_d_more) == 1 ) $search_date_d_more = "0".$search_date_d_more;
			if( strlen($search_date_m_less) == 1 ) $search_date_m_less = "0".$search_date_m_less;
			if( strlen($search_date_d_less) == 1 ) $search_date_d_less = "0".$search_date_d_less;
	
			$search_keyword->search_date_more = $search_date_y_more."-".$search_date_m_more."-".$search_date_d_more;
			$search_keyword->search_date_less = $search_date_y_less."-".$search_date_m_less."-".$search_date_d_less;



			$search_keyword->search_spam_type = $_GET["search_spam_type"];

			if( $search_keyword->search_spam_type == null || $search_keyword->search_spam_type == "all" ){
				$search_keyword->search_spam_type = "";
			}else{
				$search_keyword->search_spam_type = $_GET["search_spam_type"];
			}
			//$search_keyword =  $_GET["search_keyword"];
			//$search_target = $_GET["search_target"];
			// 정렬 세팅
			$order_by = $_GET["order_by"];
			$order = $_GET["order"];
			
			$obj = new antispamAdminController();
			if( $func == 'getStore' ){
				$output = $obj->getStoreList( $search_board, $search_keyword, $search_target, $page, $list_count, 
				$page_count, $order_by, $order);
			}
			else if( $func == 'getLog' ){
				$output = $obj->getLogList( $search_board, $search_keyword, $search_target, $page, $list_count, 
				$page_count, $order_by, $order);
			}
			else if( $func == 'getBlackList' ){
				$output = $obj->getBlackList( $search_board, $search_keyword, $search_target, $page, $list_count, 
				$page_count);
			}
			else{
				$output = $obj->getDocumentList( $search_board, $search_keyword, $search_target, $page, $list_count, 
				$page_count, $order_by, $order);
			}

			return $output;
		}

		/* 기존 글의 스팸지수와 스팸설정 날짜를 갱신하고 스팸 값 출력 */
		function setExistingDocSpamScore($search_board, $content,$id, $spam_config_regdate ){
			$obj = new antispamAdminController();
			return $obj->setExistingDocSpamScore( $search_board, $content,$id, $spam_config_regdate );
		}

		/* 스팸보관함에 스팸 넣기 */
		function insertContentInStore($content, $board){
			$obj = new antispamAdminController();
			return $obj->insertContentInStore($content, $board);	
		}


		/* 스팸로그에 스팸 넣기 */
		function insertContentInLog($score, $type, $content, $id, $date, $ip){
			$obj = new antispamAdminController();
			return $obj->insertContentInLog($score, $type, $content, $id, $date, $ip);
		}

		/* 해당게시판의 해당id 글 삭제 */
		function deleteContent($search_board, $id, $func='0'){
			$obj = new antispamAdminController();
			if( $func == 'deleteStore' ){
				$output = $obj->deleteStoreContent($search_board, $id);
			}else{
				$output = $obj->deleteContent($search_board, $id);
			}

			return $output;				
		}


		/* 스팸지수 산출*/
		function dispSpam($content) {
			$obj = new antispamAdminController();
			return $obj->getResult( $obj->procGetSpamScore($content) );
		}



		/* 차단회원 등록 */
		/*
		function addBlockMember($id, $spam_type, $spam_score, $content, $subject='0'){
			$obj = new antispamAdminController();
			return $obj->addBlockMember($id, $spam_type, $spam_score, $content, $subject);
		}
		*/


		/* spammer인지 판단 */
		function isSpammer($id, $ip){
			$model = new antispamModel();
			$config = $model->getDBbyXML("antispam.getAdmConfig")->data;
			
			$obj = new antispamAdminController();
			$is_spammer_member = false;
			$is_spammer_ip = false;

			if( $config->use_block_member == 'Y' ){
				//계정차단 설정된 경우
				$is_spammer_member = $obj->isSpammerById($id);
			}else{
				$is_spammer_member = false;
			}

			if( $config->use_block_ip == 'Y' ){
				//계정차단 설정된 경우
				$is_spammer_ip = $obj->isSpammerByIp($ip);
			}else{
				$is_spammer_ip = false;
			}

			if( (true == $is_spammer_member) || (true == $is_spammer_ip) ){
				return true;
			}		
		}
		
		/* 블랙리스트 업데이트 */
		function updateBlackList($id, $ip, $content, $subject, $spam_type="", $spam_score="" ){
			$model = new antispamModel();
			$config = $model->getDBbyXML("antispam.getAdmConfig")->data;

			$obj = new antispamAdminController();
			if( $config->use_block_member == 'Y' ){
				//계정차단 설정된 경우
				$obj->updateBlackListById($id, $ip, $content, $subject, $spam_type, $spam_score);
			}
			
			if( $config->use_block_ip == 'Y' ){
				//IP차단 설정된 경우
				$obj->updateBlackListByIp($id, $ip, $content, $subject, $spam_type, $spam_score);
			}
		}

		
	}
?>




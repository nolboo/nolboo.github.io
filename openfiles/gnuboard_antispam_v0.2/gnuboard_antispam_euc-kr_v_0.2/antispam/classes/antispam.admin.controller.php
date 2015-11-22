<?php

	require_once("./_common.php");
	require_once("$base/antispam/classes/antispam.model.php");
	require_once("$base/antispam/libs/RequestGetSpamScores.class.php");
	require_once("$base/antispam/libs/RequestPutSpamReport.class.php");
	
	class antispamAdminController{
		
		/*	설정 저장 */
		function procantispamAdminConfigUpdate($params) {

			$args->use_antispam = $params->use_antispam=='Y'?'Y':'N';
			$args->score_antispam = $params->score_antispam;
			$args->phone1 = $params->phone1;
			$args->phone2 = $params->phone2;
			$args->phone3 = $params->phone3;
			$args->mail1 = $params->mail1;
			$args->mail2 = $params->mail2;
			$args->mail3 = $params->mail3;
			$args->use_block_member = $params->use_block_member=='Y'?'Y':'N';
			$args->use_block_ip = $params->use_block_ip =='Y'?'Y':'N';
			$args->score_block_member = $params->score_block_member;
			$args->score_block_ip = $params->score_block_ip;
			$args->date_block_member = $params->date_block_member;
			$args->date_block_ip = $params->date_block_ip;

			$exception_word_list = array();
			$exception_word_list = explode('|@|',$params->exception_word_list);

			$args->exception_word_list = serialize($exception_word_list);

				

			$model = new antispamModel();
			
			/* 스패머 관리 초기화 */
			/*
			$config = $model->getDBbyXML('antispam.getAdmConfig')->data;
			if( $config->use_block_member == 'N' && $args->use_block_member == 'Y' ){
				$model->getDBbyXML("antispam.deleteBlackListId", $param);
			}
			if( $config->use_block_ip == 'N' && $args->use_block_ip == 'Y'  ){
				$model->getDBbyXML("antispam.deleteBlackListIp", $param);
			}
			*/
			return $model->setantispamAdminConfig($args);
		}

		
		/* 체크 된 글에 스팸정책 적용 */
		function applySpamConfig($check_list, $board) {
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			//모델에서 설정된 스팸지수 얻음
			$model = new antispamModel();
			$config = $model->getDBbyXML('antispam.getAdmConfig');
			if(	$config->data->use_antispam == "N" ){
				return 1;
			}
			foreach( $id_arr as $id ){
				//해당 id의 글을 불러옴
				$arg->wr_id = $id;
				$content = $model->getDBbyXML("antispam.get$board", $arg);

				//해당글의 스팸지수와 비교
				if( $content->data[1]->spam_score >= $config->data->score_antispam  ){
					//이상이면 스팸보관함으로 이동
					$this->insertContentInStore($content->data[1], $board);
					$this->deleteContent($board, $id);
				}
			}
			return 1;	
			//성공 1, 실패 0
		}
		
		/* 신고된 글 처리 */
		function sendSpamContents($check_list, $board){
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			//모델에서 설정된 스팸지수 얻음
			$model = new antispamModel();
			foreach( $id_arr as $id ){
				//해당 id의 글을 불러옴
				$arg->wr_id = $id;
				$content = $model->getDBbyXML("antispam.get$board", $arg);
		
			

				/* 글 신고 하는 부분 추가 해야 함 */



				//스팸보관함으로 이동
				$this->insertContentInStore($content->data[1], $board);
				$this->deleteContent($board, $id);
				
			}
			return 1;	
			//성공 1, 실패 0
		}

			/* 스팸보관함에 있는 글 삭제 */
		function deleteSpamcontents($check_list, $board) {
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			$model = new antispamModel();
			foreach( $id_arr as $id ){
				//해당 id의 글을 불러옴
				$args->board = $board;
				$args->wr_id = $id;

				//스팸글 삭제
				$this->deleteStoreContent($board, $id);
			}
			return 1;	
			//성공 1, 실패 0
		}


		/* 스팸로그에 있는 글 삭제 */
		function deleteLog($check_list, $board) {
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			$model = new antispamModel();
			foreach( $id_arr as $id ){
				//해당 id의 글을 불러옴
				//$args->board = $board;
				$args->wr_id = $id;

				//스팸글 삭제
				$model->getDBbyXML("antispam.deleteLog", $args);

			}
			return 1;	
			//성공 1, 실패 0
		}



		/* 체크 된 글 복원 */
		function restoreContent($check_list, $board) {
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			$model = new antispamModel();
			foreach( $id_arr as $id ){
				//해당 id의 글을 불러옴
				$args->board = $board;
				$args->wr_id = $id;

				//스팸보관함으로 이동
				$content = $model->getDBbyXML("antispam.getStore", $args);
				$this->checkInsertXMLQuery($board);
				$this->insertContentDocumentlist($content->data[1], $board);
				$this->deleteStoreContent($board, $id);
			}
			return 1;	
			//성공 1, 실패 0
		}

		/* 차단 조치 해제 */
	
		function deleteBlackList($check_list, $board) {
			//파싱하여 변수 값 정리
			$id_arr = array();
			$id_arr = explode('|@|',$check_list);
					
			if( !isset($id_arr) ){
				return 0;
			}

			$model = new antispamModel();
			foreach( $id_arr as $v ){
				//해당 아이디 삭제
				
				$arg->user_id = $arg->user_ip = $v;
				$model->getDBbyXML("antispam.deleteBlack$board", $arg);
			}
			return 1;	
			//성공 1, 실패 0
		}
		
		
		/* 차단회원 등록 */
		/*
		function addBlockMember($id, $spam_type, $spam_score, $content, $subject){
			$args->user_id = $id;
			
			$args->spam_type = $spam_type;
			$args->spam_score = $spam_score;
			$args->subject = $subject;
			$args->content = $content;

			$args->user_ip = $_SERVER['REMOTE_ADDR'];
			$args->datetime = date('Y-m-d H:i:s');
			
			$args->manage = '계정차단'; //테스트(IP로 할건지 계정으로 할건지 정해야함)

			$model = new antispamModel();
			
			//차단
			$model->getDBbyXML("antispam.insertBlockMember", $args);
			

			$params->mb_id = $id;
			$params->mb_spammer = 1;
			//회원을 스패머로 설정
			$model->getDBbyXML("antispam.updateMember", $params);
		}
		*/	
		/* 블랙리스트 업데이트(id) */
		function updateBlackListByid($id, $ip, $content, $subject, $spam_type, $spam_score){
			
			if( $id == null ){
				//게스트 계정일 경우 ID 블랙리스트에 추가시키지 않음
				return false;
			}
			$args->user_id = $id;
			$args->user_ip = $ip;
			
			
			$args->subject = $subject;
			$args->content = $content;
		
			$args->datetime = date('Y-m-d H:i:s');


			//기존에 있는지 확인
			$model = new antispamModel();
			$id_param->user_id = $args->user_id;
			$output = $model->getDBbyXML("antispam.getBlackListId", $id_param)->data;

			
			if( ($spam_type=="") && ($spam_score =="") ){
					//스팸지수요청을 안한경우 카운팅만 해줌
					$args->spam_type = $output->spam_type;
					$args->spam_score = $output->spam_score;
			}else{
				$args->spam_type = $spam_type;
				$args->spam_score = $spam_score;
			}
			

			if( null == $output ){
				//기존 리스트에 존재 하지 않음
				if( ($spam_type=="") && ($spam_score =="") ){
					//필드를 새로 생성해야 될 상황에서 id제한에서 걸렸을경우
					$spam = $this->procGetSpamScore($subject.$content);
					$args->spam_type = $spam->type;
					$args->spam_score = $spam->score;
				}
				$args->try_write_spam = '1';
				$model->getDBbyXML("antispam.insertBlackListId", $args);
			}else{
				//기존 리스트에 존재
				$args->try_write_spam = $output->try_write_spam+1;
				$model->getDBbyXML("antispam.updateBlackListId", $args);
			}
			

			return true;
		}

		/* 블랙리스트 업데이트(ip) */
		function updateBlackListByIp($id, $ip, $content, $subject, $spam_type, $spam_score){
			$args->user_id = $id;
			$args->user_ip = $ip;

			$args->subject = $subject;
			$args->content = $content;
		
			$args->datetime = date('Y-m-d H:i:s');

			$model = new antispamModel();
			$config = $model->getDBbyXML("antispam.getAdmConfig")->data;
					
		
	
			//기존에 있는지 확인
			$model = new antispamModel();
			$ip_params->user_ip = $args->user_ip;
			$output = $model->getDBbyXML("antispam.getBlackListIp", $ip_params)->data;

			if( ($spam_type=="") && ($spam_score =="") ){
					//스팸지수요청을 안한경우 카운팅만 해줌
					$args->spam_type = $output->spam_type;
					$args->spam_score = $output->spam_score;
			}else{
				$args->spam_type = $spam_type;
				$args->spam_score = $spam_score;
			}
			
			
			if( null == $output ){
				//기존 리스트에 존재 하지 않음
				if( ($spam_type=="") && ($spam_score =="") ){
					//필드를 새로 생성해야 될 상황에서 ip제한에서 걸렸을경우
					$spam = $this->procGetSpamScore($subject.$content);
					$args->spam_type = $spam->type;
					$args->spam_score = $spam->score;
				}
				$args->try_write_spam = '1';
				$model->getDBbyXML("antispam.insertBlackListIp", $args);
			}else{
				//기존 리스트에 존재
				$args->try_write_spam = $output->try_write_spam+1;
				$model->getDBbyXML("antispam.updateBlackListIp", $args);
			}
			

			return true;
		}

		/* id로 스패머인지 판단*/
		function isSpammerById($id){
			$obj = new antispamModel();
			$args->user_id = $id;
			$log = $obj->getDBbyXML("antispam.getBlackListId", $args)->data;
			$config = $obj->getDBbyXML("antispam.getAdmConfig")->data;
			
			if( 'Y' == $config->use_block_member ){
				
				$log->datetime = str_replace("-", "", $log->datetime);
				$user_day = (int)strtok($log->datetime, " ");
				
				$today = (int)date('Ymd');

				if( ($today-$user_day) >= $config->date_block_member ){
					//삭제
					$arg->user_id = $id;
					$obj->getDBbyXML("antispam.deleteBlackId", $arg);
					return false;
				}					
				
				
				//시도횟수 초과
				if( $config->score_block_member <= $log->try_write_spam ){
					return true;
				}
			}
			return false;
		}

		/* ip로 스패머인지 판단 */
		function isSpammerByIp($ip){
			$obj = new antispamModel();
			$args->user_ip = $ip;
			$log = $obj->getDBbyXML("antispam.getBlackListIp", $args)->data;

			$config = $obj->getDBbyXML("antispam.getAdmConfig")->data;
			if( 'Y' == $config->use_block_ip ){

				$log->datetime = str_replace("-", "", $log->datetime);
				$user_day = (int)strtok($log->datetime, " ");
				
				$today = (int)date('Ymd');

				if( ($today-$user_day) >= $config->date_block_member ){
					//삭제
					$arg->user_ip = $ip;
					$obj->getDBbyXML("antispam.deleteBlackIp", $arg);
					return false;
				}

				if( $config->score_block_ip <= $log->try_write_spam ){
					return true;
				}
			}
			return false;
		}


		/* 스팸지수 산출 */
		function procGetSpamScore($request, $exception='#db'){
					
			/* 예외단어 DB에서 가져오는 경우 */
			if( $exception == '#db' ){
				$model = new antispamModel();

				$exception = array();
				$exception = unserialize($model->getDBbyXML('antispam.getAdmConfig')->data->exception_word_list );
			}
			
			
			if( $exception != null ){
				/*	예외단어 제거 */
				foreach( $exception as $exception_word ){
					$request = str_replace($exception_word, "", $request);
				}
			}
			

			$ip = $_SERVER['REMOTE_ADDR'];
			$time = date('Y-m-d H:i:s');



			/* 스팸지수 요청 */
			$oReq = new RequestGetSpamScores();
			if( false == $oReq->addContent($request,$ip,$time) ){
				return null;
			}
			/* 스팸 지수 */
			$output = $oReq->request();
			$result->score = $output->scores->item[0]->score;
			$result->type = $output->scores->item[0]->type;
			return $result;
		}

		function getResult($result){		
			$model = new antispamModel();
			$config = $model->getDBbyXML('antispam.getAdmConfig');
	
			if( $config->data->use_antispam == "Y" ){
				if( $result->score < $config->data->score_antispam ){
					return null;	//일반
				}else{
					return $result;	//스팸
				}
			}else{
				return null;	//일반
			}
			
		}

		/* 테스트 결과 */
		function getTestResult($score, $type,$use_antispam, $score_antispam){

			/* 스팸 판단 */	
			if( null == $score ){
				$result->result = -1;	//error
			}
	
			else if( $use_antispam == "N" ){
				$result->result = 0;
			}
			else if( $score <  $score_antispam ){
				$result->result = 0;	//일반글
			}else{
				$result->result = 1;	//스팸글
			}

			$result->type = $type;
			$result->score = (100 <= $score) ? substr($score,0,3) : substr($score,0,2);
			return $result;
		}


		/* 현재 게시판의 종류 출력 */
		function checkCurrentBoard($search_board, $list){
			/* 게시판이 하나도 존재 않을 경우 */
			if( $list->data == null ){
				return false;	
			}

			if( sizeof($list->data) == 1 ){
				$search_board = $list->data->bo_table;
				return $search_board;
			}

			/* 현재 설정된 게시판이 없을 경우 예외처리 */
			foreach( $list->data as $bd ){
				
				if( $search_board == $bd->bo_table ){
					$exist = 1;
					break;	
				}
			}
			if( $exist != 1 ){
				$bd = $list->data[0];
				$search_board = $list->data[0]->bo_table;
			}
			
			return $search_board;
		}

		/* 게시판의 글 출력 */
		function getDocumentList($search_board, $search_keyword, $search_target, $page, $list_count, $page_count, $order_by, $order){
			if( $page < 1 ){
				$page = 1;
			}
			$args->page = $page;
			//한페이지에 보이는 수
			$args->list_count = $list_count;
			//한번에 보여지는 페이지 수
			$args->page_count = $page_count;
			
			//검색조건
			$args->wr_id = "";
			$args->wr_content = $search_keyword->search_content;
			$args->mb_id = $search_keyword->search_writer;
			$args->wr_ip = $search_keyword->search_ip;
			$args->spam_score_more = $search_keyword->search_spam_score_more;
			$args->spam_score_less = $search_keyword->search_spam_score_less;
			$args->wr_datetime_more = $search_keyword->search_date_more;
			$args->wr_datetime_less = $search_keyword->search_date_less; 

			if( $args->spam_score_more == 0 && $args->spam_score_less == 100 ){
				$args->spam_score_more = "";
				$spam_score_more = "0";
				$args->spam_score_less = "";
				$spam_score_less = "100";
			}else{
				$spam_score_more = $args->spam_score_more;
				$spam_score_less = $args->spam_score_less;
			}

			//정렬
			if( $order_by == null ){
				$order_by = 'wr_datetime';
			}
			if( $order == null ){
				$order = 'desc';
			}

			$args->list_order = $order_by;	//정렬기준
			$args->desc= $order;	//정렬방법

			//위의 조건에 해당 하는 글 모두 리턴
			$obj = new antispamModel();

			$this->checkGetXMLQuery($search_board);
			$output = $obj->getDBbyXML("antispam.get$search_board", $args);

			$output->order_by = $order_by;
			$output->order = $order;

			$output->search_content = $search_keyword->search_content;	
			$output->search_writer = $search_keyword->search_writer;		
			$output->search_ip = $search_keyword->search_ip;
			$output->search_spam_score_more = $spam_score_more;
			$output->search_spam_score_less = $spam_score_less;
					
				


			$output->search_date_y_more = $search_keyword->search_date_y_more;
			$output->search_date_y_less = $search_keyword->search_date_y_less;

			$output->search_date_m_more = $search_keyword->search_date_m_more;
			$output->search_date_m_less = $search_keyword->search_date_m_less;

			$output->search_date_d_more = $search_keyword->search_date_d_more;
			$output->search_date_d_less = $search_keyword->search_date_d_less;
			return $output;
		}

		/* 스팸보관함의 글 출력 */
		function getStoreList($search_board, $search_keyword, $search_target, $page, $list_count, $page_count, $order_by, $order){
			if( $page < 1 ){
				$page = 1;
			}
			$args->page = $page;
			//한페이지에 보이는 수
			$args->list_count = $list_count;
			//한번에 보여지는 페이지 수
			$args->page_count = $page_count;
			//검색조건
			$args->wr_id = "";
			$args->wr_content = $search_keyword->search_content;
			$args->mb_id = $search_keyword->search_writer;
			$args->wr_ip = $search_keyword->search_ip;
			$args->spam_score_more = $search_keyword->search_spam_score_more;
			$args->spam_score_less = $search_keyword->search_spam_score_less;
			$args->wr_datetime_more = $search_keyword->search_date_more;
			$args->wr_datetime_less = $search_keyword->search_date_less; 

			//정렬
			if( $order_by == null ){
				$order_by = 'wr_datetime';
			}
			if( $order == null ){
				$order = 'desc';
			}

			$args->list_order = $order_by;	//정렬기준
			$args->desc= $order;	//정렬방법

			//위의 조건에 해당 하는 글 모두 리턴
			$obj = new antispamModel();
	
				
			$args->board = $search_board;
			$output = $obj->getDBbyXML("antispam.getStore", $args);

			$output->search_target = $search_target;
			//$output->search_keyword = $search_keyword;

			$output->order_by = $order_by;
			$output->order = $order;

			$output->search_content = $search_keyword->search_content;	
			$output->search_writer = $search_keyword->search_writer;		
			$output->search_ip = $search_keyword->search_ip;
			$output->search_spam_score_more = $search_keyword->search_spam_score_more;
			$output->search_spam_score_less = $search_keyword->search_spam_score_less;
					
			$output->search_date_y_more = $search_keyword->search_date_y_more;
			$output->search_date_y_less = $search_keyword->search_date_y_less;

			$output->search_date_m_more = $search_keyword->search_date_m_more;
			$output->search_date_m_less = $search_keyword->search_date_m_less;

			$output->search_date_d_more = $search_keyword->search_date_d_more;
			$output->search_date_d_less = $search_keyword->search_date_d_less;
			return $output;
		}

		/* 스팸로그 출력 */
		function getLogList($search_board, $search_keyword, $search_target, $page, $list_count, $page_count, $order_by, $order){
			if( $page < 1 ){
				$page = 1;
			}
			$args->page = $page;
			//한페이지에 보이는 수
			$args->list_count = $list_count;
			//한번에 보여지는 페이지 수
			$args->page_count = $page_count;
			//검색조건
			$args->wr_id = "";
			$args->wr_content = $search_keyword->search_content;
			$args->mb_id = $search_keyword->search_writer;
			$args->wr_ip = $search_keyword->search_ip;
			$args->spam_score_more = $search_keyword->search_spam_score_more;
			$args->spam_score_less = $search_keyword->search_spam_score_less;
			$args->wr_datetime_more = $search_keyword->search_date_more;
			$args->wr_datetime_less = $search_keyword->search_date_less; 
			//타입
			$args->spam_type = $search_keyword->search_spam_type; 

			//정렬
			if( $order_by == null ){
				$order_by = 'wr_datetime';
			}
			if( $order == null ){
				$order = 'desc';
			}

			$args->list_order = $order_by;	//정렬기준
			$args->desc= $order;	//정렬방법

			//위의 조건에 해당 하는 글 모두 리턴
			$obj = new antispamModel();
	
				
			//$args->board = $search_board;
			$output = $obj->getDBbyXML("antispam.getLog", $args);

			$output->order_by = $order_by;
			$output->order = $order;

			$output->search_content = $search_keyword->search_content;	
			$output->search_writer = $search_keyword->search_writer;		
			$output->search_ip = $search_keyword->search_ip;
			$output->search_spam_score_more = $search_keyword->search_spam_score_more;
			$output->search_spam_score_less = $search_keyword->search_spam_score_less;
					
			$output->search_date_y_more = $search_keyword->search_date_y_more;
			$output->search_date_y_less = $search_keyword->search_date_y_less;

			$output->search_date_m_more = $search_keyword->search_date_m_more;
			$output->search_date_m_less = $search_keyword->search_date_m_less;

			$output->search_date_d_more = $search_keyword->search_date_d_more;
			$output->search_date_d_less = $search_keyword->search_date_d_less;

			if( "" == $search_keyword->search_spam_type ){
				$output->spam_type = "all";
			}

			return $output;
		}


		/* 블랙리스트 출력 */
		function getBlackList($search_board, $search_keyword, $search_target, $page, $list_count, $page_count){
			if( $page < 1 ){
				$page = 1;
			}

			$args->page = $page;
			//한페이지에 보이는 수
			$args->list_count = $list_count;
			//한번에 보여지는 페이지 수
			$args->page_count = $page_count;
			

			$obj = new antispamModel();
			$config = $obj->getDBbyXML("antispam.getAdmConfig", $args)->data;
			
			if( $search_board == "getBlackListIdDisp" ){
				if( 'Y' == $config->use_block_member ){
					$args->try_write_spam = $config->score_block_member;
				}else{
					$args->try_write_spam = PHP_INT_MAX;
				}	
			}else if( $search_board == "getBlackListIpDisp" ){
				if( 'Y' == $config->use_block_ip ){
					$args->try_write_spam = $config->score_block_ip;
				}else{
					$args->try_write_spam = PHP_INT_MAX;
				}
			}else{
				$args->try_write_spam = PHP_INT_MAX;
			}

			
			$args->list_order = "datetime";	//정렬기준
			$args->desc = 'desc';	//정렬방법

			//위의 조건에 해당 하는 글 모두 리턴

			$output = $obj->getDBbyXML("antispam.$search_board", $args);

			//$output->search_target = $search_target;
			//$output->search_keyword = $search_keyword;
			return $output;
		}
	
		/* 기존 글의 스팸지수와 스팸설정 날짜를 갱신하고 스팸 값 출력 */
		function setExistingDocSpamScore($search_board, $content, $id, $spam_config_exception_word){
			$result = $this->procGetSpamScore($content);
			if( null == $result->score ){
				return null;	//error
			}else{
				$args->spam_score = $result->score;	//test
			}
			$args->spam_config_exception_word = $spam_config_exception_word;
			$args->wr_id = $id;
			
			$args->spam_type = $result->type;


			
			$obj = new antispamModel();
			$this->checkUpdateXMLQuery($search_board);
			$obj->getDBbyXML("antispam.update$search_board", $args);
			
			return $result;
		}

		/* 문서보관함에 스팸 넣기 */
		function insertContentDocumentlist($content, $board){
			$obj = new antispamModel();
			return $obj->getDBbyXML("antispam.insert$board", $content);
		}

		/* 스팸보관함에 스팸 넣기 */
		function insertContentInStore($content, $board){
			$content->board = $board;
			$obj = new antispamModel();
			return $obj->getDBbyXML("antispam.insertStore", $content);
		}

		/* 스팸로그 스팸 넣기 */
		function insertContentInLog($score, $type, $content, $id, $date, $ip){
			$args->spam_score=$score;
			$args->spam_type=$type;
			$args->wr_content=$content;
			$args->mb_id=$id;
			$args->wr_datetime=$date;
			$args->wr_ip=$ip;


			$obj = new antispamModel();
			return $obj->getDBbyXML("antispam.insertLog", $args);
		}
		
		/* 해당게시판의 해당id 글 삭제 */
		function deleteContent($search_board, $id){
			$obj = new antispamModel();
			$arg->wr_id = $id;
					
			$this->checkDeleteXMLQuery( $search_board );
			$obj->getDBbyXML("antispam.delete$search_board", $arg);
			return $content;
		}

		/* 스팸보관함의 해당id 글 삭제 */
		function deleteStoreContent($search_board, $id){
			$obj = new antispamModel();
			$args->wr_id = $id;
			$args->board = $search_board;
			
			$obj->getDBbyXML("antispam.deleteStore", $args);
			return $content;
		}


	
		/* 해당 게시판에 해당하는 쿼리 파일이 있는지 확인(없으면 생성) */
		function checkGetXMLQuery($board){
	
			$model = new antispamModel();

			$xml_file = sprintf('queries/get%s.xml',$board );
			if(!file_exists($xml_file)){
			
				//컬럼추가
				$model->addColumn("write_".$board, "spam_score", "number", "11");
				$model->addColumn("write_".$board, "spam_type", "varchar", "10");
				$model->addColumn("write_".$board, "spam_config_exception_word", "text", "0");
				
				/* 쿼리 생성 */
				$buff = "
				<query id=\"get".$board."\" action=\"select\">
						<tables>
							<table name=\"write_".$board."\" />
						</tables>
						<columns>
							<column name=\"*\" />
						</columns>
						<conditions>
							<condition operation=\"equal\" column=\"wr_id\" var=\"wr_id\" pipe=\"and\" />
							<condition operation=\"like\" column=\"wr_content\" var=\"wr_content\" pipe=\"and\" />
							<condition operation=\"like\" column=\"mb_id\" var=\"mb_id\" pipe=\"and\" />
							<condition operation=\"more\" column=\"wr_datetime\" var=\"wr_datetime_more\" pipe=\"and\" />
							<condition operation=\"less\" column=\"wr_datetime\" var=\"wr_datetime_less\" pipe=\"and\" />
							<condition operation=\"like\" column=\"wr_ip\" var=\"wr_ip\" pipe=\"and\" />
							<condition operation=\"more\" column=\"spam_score\" var=\"spam_score_more\" pipe=\"and\" />
							<condition operation=\"less\" column=\"spam_score\" var=\"spam_score_less\" pipe=\"and\" />
						</conditions>
					<navigation>
						<index var=\"list_order\" default=\"wr_datetime\" order=\"desc\" />
						<list_count var=\"list_count\" default=\"3\" />
					    <page_count var=\"page_count\" default=\"3\" />
					    <page var=\"page\" default=\"1\" />
					</navigation>
				</query>";
				$mode="w";
				$file_name = "queries/get".$board.".xml";

				$mode = strtolower($mode);
		        if($mode != "a") $mode = "w";
			    $fp = fopen($file_name,$mode);
				fwrite($fp, $buff);
				fclose($fp);
				@chmod($file_name, 0644);
			}

		}

		/* 해당 게시판에 해당하는 쿼리 파일이 있는지 확인(없으면 생성) */
		function checkUpdateXMLQuery($board){
			$xml_file = sprintf('queries/update%s.xml',$board );
			if(!file_exists($xml_file)){
				/* 쿼리 생성 */
				$buff =
				"<query id=\"update".$board."\" action=\"update\">
					<tables>
						<table name=\"write_".$board."\" />
					</tables>
					<columns>
						<column name=\"spam_score\" var=\"spam_score\" default='0' />
						<column name=\"spam_type\" var=\"spam_type\" default='null' />
						<column name=\"spam_config_exception_word\" var=\"spam_config_exception_word\" default='' />
					</columns>
					<conditions>
						<condition operation=\"equal\" column=\"wr_id\" var=\"wr_id\" />	
					</conditions>
				</query>";
				$mode="w";
				$file_name = "queries/update".$board.".xml";

				$mode = strtolower($mode);
		        if($mode != "a") $mode = "w";
			    $fp = fopen($file_name,$mode);
				fwrite($fp, $buff);
				fclose($fp);
				@chmod($file_name, 0644);
			}

		}
		
		/* 해당 게시판에 해당하는 쿼리 파일이 있는지 확인(없으면 생성) */
		function checkDeleteXMLQuery($board){
			$xml_file = sprintf('queries/delete%s.xml',$board );
			if(!file_exists($xml_file)){
				/* 쿼리 생성 */
				$buff =
				"<query id=\"delete".$board."\" action=\"delete\">
					<tables>
						<table name=\"write_".$board."\" />
					</tables>
					<conditions>
						<condition operation=\"equal\" column=\"wr_id\" var=\"wr_id\" />	
					</conditions>
				</query>";
				$mode="w";
				$file_name = "queries/delete".$board.".xml";

				$mode = strtolower($mode);
		        if($mode != "a") $mode = "w";
			    $fp = fopen($file_name,$mode);
				fwrite($fp, $buff);
				fclose($fp);
				@chmod($file_name, 0644);
			}
		}

		/* 해당 게시판에 해당하는 쿼리 파일이 있는지 확인(없으면 생성) */
		function checkInsertXMLQuery($board){
			$xml_file = sprintf('queries/insert%s.xml',$board );
			if(!file_exists($xml_file)){
				/* 쿼리 생성 */
				$buff =
				"<query id=\"insert".$board."\" action=\"insert\">
					<tables>
						<table name=\"write_".$board."\" />
					</tables>
					<columns>
						<column name=\"wr_id\" var=\"wr_id\" />
						<column name=\"wr_num\" var=\"wr_num\" />
						<column name=\"wr_reply\" var=\"wr_reply\" />
						<column name=\"wr_parent\" var=\"wr_parent\" />
						<column name=\"wr_is_comment\" var=\"wr_is_comment\" />
						<column name=\"wr_comment\" var=\"wr_comment\" />
						<column name=\"wr_comment_reply\" var=\"wr_comment_reply\" />
						<column name=\"ca_name\" var=\"ca_name\" />
						<column name=\"wr_option\" var=\"wr_option\" />
						<column name=\"wr_subject\" var=\"wr_subject\" />
						<column name=\"wr_content\" var=\"wr_content\" />
						<column name=\"wr_link1\" var=\"wr_link1\" />
						<column name=\"wr_link2\" var=\"wr_link2\" />
						<column name=\"wr_link1_hit\" var=\"wr_link1_hit\" />
						<column name=\"wr_link2_hit\" var=\"wr_link2_hit\" />
						<column name=\"wr_trackback\" var=\"wr_trackback\" />
						<column name=\"wr_hit\" var=\"wr_hit\" />
						<column name=\"wr_good\" var=\"wr_good\" />
						<column name=\"wr_nogood\" var=\"wr_nogood\" />
						<column name=\"mb_id\" var=\"mb_id\" />
						<column name=\"wr_password\" var=\"wr_password\" />
						<column name=\"wr_name\" var=\"wr_name\" />
						<column name=\"wr_email\" var=\"wr_email\" />
						<column name=\"wr_homepage\" var=\"wr_homepage\" />
						<column name=\"wr_datetime\" var=\"wr_datetime\" />
						<column name=\"wr_last\" var=\"wr_last\" />
						<column name=\"wr_ip\" var=\"wr_ip\" />
						<column name=\"wr_1\" var=\"wr_1\" />
						<column name=\"wr_2\" var=\"wr_2\" />
						<column name=\"wr_3\" var=\"wr_3\" />
						<column name=\"wr_4\" var=\"wr_4\" />
						<column name=\"wr_5\" var=\"wr_5\" />
						<column name=\"wr_6\" var=\"wr_6\" />
						<column name=\"wr_7\" var=\"wr_7\" />
						<column name=\"wr_8\" var=\"wr_8\" />
						<column name=\"wr_9\" var=\"wr_9\" />
						<column name=\"wr_10\" var=\"wr_10\" />
						<column name=\"spam_score\" var=\"spam_score\" />
						<column name=\"spam_type\" var=\"spam_type\" />
						<column name=\"spam_config_exception_word\" var=\"spam_config_exception_word\" />
					</columns>
				</query>";
				$mode="w";
				$file_name = "queries/insert".$board.".xml";

				$mode = strtolower($mode);
		        if($mode != "a") $mode = "w";
			    $fp = fopen($file_name,$mode);
				fwrite($fp, $buff);
				fclose($fp);
				@chmod($file_name, 0644);
			}
		}
	}
?>

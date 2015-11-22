<?php
	$lang->version="0.2";
	$lang->help_user = '※ 본 「게시판 스팸 실시간 차단시스템」 이용 중 발생되는 모든 문제에 대한 민?형사상 책임은 이용자에게 있음.';


	$lang->help_config = '스팸등록을 차단 할 수 있도록 스팸지수를 설정합니다. 스팸지수 기본값은 \'60\'이며 게시글의 스팸지수가 설정된 값 이상으로 측정되면 게시자는 해당 글을 등록할 수 없게 됩니다. 스팸지수는 운영자가 적정 수준으로 설정할 수 있습니다.';
	$lang->help_store = '\'전체게시글목록\'에서 스팸으로 처리된 스팸목록을 확인할 수 있습니다. \'선택 복원\'을 통해 해당 글을 운영중인 게시판으로 복원할 수 있습니다.
';
	$lang->help_documents = '운영중인 게시판의 모든 글을 이곳에서 확인할 수 있습니다. 게시판의 스팸을 \'스팸설정 적용\'으로 일괄처리 할 수 있습니다. 처리결과 스팸으로 판단된 글은 운영중인 게시판에서 \'스팸게시글관리\'로 이동됩니다.';
	$lang->help_black = '스팸등록을 여러번 시도하여 차단된 계정/IP 목록을 확인 및 조치할 수 있습니다.';
	$lang->help_log = '스팸으로 판단되어 글 등록이 차단된 글을 볼 수 있습니다. 아래의 스팸목록은 실제 운영중인 게시판에는 존재하지 않습니다.';

	$lang->not_exist_contents = '자료가 없습니다.';

	$lang->title = '제목 : ';
	$lang->content = '내용 : ';
	$lang->comment = '댓글 : ';

	$lang->install_start = '설치를 시작합니다.';
	$lang->install_complete = '설치가 완료되었습니다.';

	$lang->using = '사용';
	$lang->enter = '저장';
	$lang->del = '삭제';
	$lang->fail = '실패';
	$lang->cmd_search = '검색';

	$lang->error_server = '스팸차단시스템이 점검중 입니다.';

	$lang->first_page = '처음';
	$lang->last_page = '맨끝';
	$lang->next_page = '다음';
	$lang->prev_page = '이전';

	$lang->subtitle_config = '설정';
	$lang->subtitle_store = '스팸게시글관리';
	$lang->subtitle_documents = '전체게시글목록';
	$lang->subtitle_black = '계정/IP차단관리';
	$lang->subtitle_log = '스팸차단로그';

	//설정페이지
	
	$lang->use_antispam = '스팸차단 설정';
	$lang->about_use_antispam_a = '스팸지수';
	$lang->about_use_antispam_b = '이상이면 글 등록 제한';
	
	$lang->use_block_member = '계정차단 설정';
	$lang->use_block_ip = 'IP차단 설정';
	$lang->block_member = '계정차단';
	$lang->block_ip = 'IP차단';
	$lang->list_block_member = '계정차단 목록';
	$lang->list_block_ip = 'IP차단 목록';
	$lang->about_use_block_a = '스팸등록 시도';
	$lang->about_use_block_member = '회 이상이면 해당 계정 글 등록 차단';
	$lang->about_use_block_ip = '회 이상이면 해당 IP 글 등록 차단';
	
	$lang->about_date_block_a = '( 차단기간 : ';
	$lang->about_date_block_b = '일 )';
	

	
	$lang->except_word = '예외단어 등록';
	$lang->about_except_word = '* 아래 단어들은 스팸성 단어로 판단되지 않습니다.';

	$lang->test_spam = '스팸지수 측정';
	$lang->about_test_spam = '* 아래의 글의 스팸지수를 측정합니다.';
	$lang->check_spam = '스팸지수 측정';

	$lang->update_adm_config_success = '설정이 저장되었습니다.';

	$lang->score_antispam_default = '60';
	$lang->score_block_default = '10';
	$lang->date_block_default = '1';

	
	$lang->is_not_spam = '해당 글은 스팸으로 판단되지 않았습니다.';


	
	//문서 목록 페이지
	$lang->cmd_apply_spam_settings = '스팸설정 적용';
	$lang->cmd_report_as_spam_and_delete = '스팸신고';
	
	$lang->no = '번호';
	$lang->document = '게시글';
	$lang->document_type = '유형';
    $lang->nick_name = '글쓴이';
    $lang->readed_count = '조회';
    $lang->regdate = '날짜';
    $lang->ipaddress = 'IP';
    $lang->spamscore = '스팸지수';
	$lang->spamtype = '스팸분류';
	$lang->board_type = '게시판';
	$lang->try_write_spam = '시도';

	$lang->reply = '댓글';
	

	//스팸보관 목록
	$lang->sel_res = '선택 복원';
	$lang->sel_del = '선택 삭제';

	
	$lang->applySpamConfig_success = '스팸으로 판단된 글은 스팸보관함으로 이동되었습니다.';
	$lang->restore_content_success = '복원되었습니다.';
	$lang->send_content_success = '선택된 글은 스팸보관함으로 이동되었습니다.';
	$lang->delete_content_success = '삭제가 완료되었습니다.';
	

	$lang->manage = '조치';
	$lang->id = '아이디';
	$lang->res_spammer = '조치해제';

	//예외처리
	$lang->exception_incorrect_spam_score = "스팸차단 설정 : 1~100 사이의 정수를 입력하여 주십시오.";
	$lang->exception_incorrect_block_member_score = "계정차단 설정 : 1 이상의 정수를 입력하여 주십시오.";
	$lang->exception_incorrect_block_ip_score = "ip차단 설정 : 1 이상의 정수를 입력하여 주십시오.";
	$lang->exception_not_exist_text = "글을 입력하여 주십시오.";
	$lang->exception_not_exist_check = "해당 글을 체크하여 주십시오.";

	//경고
	$lang->alert_test_is_not_spam = '해당 글은 스팸으로 판단되지 않았습니다.\\n스팸지수 : ';	
	$lang->alert_test_is_spam = '해당 글은 스팸으로 판단되어 글 등록이 제한됩니다.\\n스팸지수 : ';
	$lang->alert_is_spammer = "스팸글 등록을 여러번 시도하여 글등록이 제한되었습니다. \\n관리자에게 문의하여 주십시오.";
	$lang->alert_is_spam = "해당 글은 스팸으로 판단되어 글 등록이 제한되었습니다.\\n스팸 등록을 여러번 시도 할 경우 글쓰기 기능이 제한 될 수 있습니다.\\n관리자에게 문의하여 주십시오.";
	$lang->no_board = "게시판이 존재하지 않습니다.";
?>

<?php

// 페이징 사용자 함수
function paging($page, $total_page, $page_scale, $total_count, $ext = '')
{
    // 1. 전체 페이지 계산
		

    // 2. 페이징을 출력할 변수 초기화
    $paging_str = "";

    // 3. 처음 페이지 링크 만들기
//    if ($page > 1) {
        $paging_str .= "<a href='".$_SERVER[PHP_SELF]."?page=1&".$ext."'>처음</a>";
//    }

    // 4. 페이징에 표시될 시작 페이지 구하기
    $start_page = ( (ceil( $page / $page_scale ) - 1) * $page_scale ) + 1;

    // 5. 페이징에 표시될 마지막 페이지 구하기
    $end_page = $start_page + $page_scale - 1;
    if ($end_page >= $total_page) $end_page = $total_page;

    // 6. 이전 페이징 영역으로 가는 링크 만들기
    if ($start_page > 1){
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($start_page - 1)."&".$ext."'>...</a>";
    }

    // 7. 페이지들 출력 부분 링크 만들기
    if ($total_page >= 1) {
        for ($i=$start_page;$i<=$end_page;$i++) {
            // 현재 페이지가 아니면 링크 걸기
            if ($page != $i){
                $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$i."&".$ext."'><span>$i</span></a>";
            // 현재페이지면 굵게 표시하기
            }else{
                $paging_str .= " &nbsp;<b>$i</b> ";
            }
        }
    }

    // 8. 다음 페이징 영역으로 가는 링크 만들기
    if ($total_page > $end_page){
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".($end_page + 1)."&".$ext."'>...</a>";
    }

    // 9. 마지막 페이지 링크 만들기
  //  if ($page < $total_page) {
        $paging_str .= " &nbsp;<a href='".$_SERVER[PHP_SELF]."?page=".$total_page."&".$ext."'>맨끝</a>";
  //  }

    return $paging_str;
}
?>


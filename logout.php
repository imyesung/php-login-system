<?php
// 세션 시작 (이미 시작되어 있을 경우 무시)
session_start();

// 세션 데이터 삭제
session_unset();  // 모든 세션 변수를 초기화

// 세션 종료
session_destroy();  // 세션을 완전히 종료

// 로그인 페이지로 리다이렉트
header("Location: login.php");
exit();
?>

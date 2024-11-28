<?php
// 헤더 설정: 클라이언트가 서버에 요청을 보낼 때 허용되는 조건을 설정합니다.
header("Access-Control-Allow-Origin: *"); // 모든 도메인에서 요청 허용
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); // 허용된 HTTP 메서드 지정
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // 허용된 요청 헤더
header("Content-Type: application/json; charset=UTF-8"); // 응답 콘텐츠 타입을 JSON 형식으로 설정

// MySQL 데이터베이스 접속 정보
$mysql_host = "income_expense_db"; // MySQL 서버의 호스트 이름 (Docker Compose의 서비스 이름 사용)
$mysql_user = "php-mysql"; // 데이터베이스 사용자 이름
$mysql_password = "123456"; // 데이터베이스 사용자 비밀번호
$mysql_db = "php-mysql"; // 사용할 데이터베이스 이름

// MySQL 데이터베이스 연결 생성
$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);

// 데이터베이스 연결이 실패하면 에러 메시지 출력
if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error()); // 연결 실패 시 에러 메시지를 출력하고 종료
}
?>

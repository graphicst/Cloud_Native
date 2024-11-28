<?php
// HTTP 응답 헤더 설정
header("Access-Control-Allow-Origin: *"); // 모든 도메인에서 CORS 요청 허용
header("Access-Control-Allow-Methods: POST"); // 허용된 HTTP 메서드를 POST로 제한
header("Content-Type: application/json; charset=utf-8"); // 응답의 콘텐츠 유형을 JSON 형식으로 설정

// 데이터베이스 연결 정보 설정
$servername = "income_expense_db"; // MySQL 서버 이름 (Docker Compose 서비스 이름)
$username = "php-mysql"; // 데이터베이스 사용자 이름
$password = "123456"; // 데이터베이스 비밀번호
$dbname = "php-mysql"; // 데이터베이스 이름

// MySQL 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 데이터베이스 연결 확인
if ($conn->connect_error) {
    // 연결 실패 시 JSON 형식으로 오류 반환 후 스크립트 종료
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 요청으로 전달된 `id` 값을 가져옴
    $id = $_POST['id'];

    // SQL 삭제문 준비 (Prepared Statement 사용)
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $id); // `id` 값에 정수 타입(i) 바인딩

    // SQL 실행 결과 확인
    if ($stmt->execute()) {
        echo json_encode(['success' => true]); // 삭제 성공 시 성공 응답 반환
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete transaction']); // 삭제 실패 시 오류 응답 반환
    }

    $stmt->close(); // Prepared Statement 닫기
} else {
    // POST 요청이 아닌 경우 오류 응답 반환
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close(); // MySQL 연결 닫기
?>

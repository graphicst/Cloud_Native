<?php
// CORS 설정: 모든 출처에서 접근 허용
header("Access-Control-Allow-Origin: *");
// HTTP 요청 메서드 설정: POST 요청만 허용
header("Access-Control-Allow-Methods: POST");
// 응답의 콘텐츠 타입을 JSON 형식으로 설정
header("Content-Type: application/json; charset=UTF-8");

// 데이터베이스 연결 정보 설정
$servername = "income_expense_db"; // MySQL 서버 이름 (Docker Compose에서 정의된 서비스 이름)
$username = "php-mysql";           // 데이터베이스 사용자 이름
$password = "123456";              // 데이터베이스 비밀번호
$dbname = "php-mysql";             // 데이터베이스 이름

// MySQL 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 데이터베이스 연결 확인
if ($conn->connect_error) {
    // 연결 실패 시 JSON 형식의 오류 메시지를 반환하고 종료
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// HTTP 요청 메서드가 POST인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 요청에서 데이터 추출
    $user_id = $_POST['user_id'] ?? null;              // 사용자 ID
    $transaction_date = $_POST['transaction_date'] ?? null; // 거래 날짜
    $category = $_POST['category'] ?? null;           // 카테고리
    $description = $_POST['description'] ?? null;     // 설명
    $amount = $_POST['amount'] ?? null;               // 금액

    // 필수 입력값 확인
    if (!$user_id || !$transaction_date || !$category || !$description || !$amount) {
        // 필수 데이터가 누락된 경우 JSON 형식의 오류 메시지 반환 후 종료
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        $conn->close(); // 데이터베이스 연결 종료
        exit;           // 스크립트 종료
    }

    // 거래 데이터 삽입 쿼리 준비
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, transaction_date, category, description, amount) VALUES (?, ?, ?, ?, ?)");
    // 데이터 바인딩: 정수(user_id), 문자열(transaction_date, category, description), 실수(amount)
    $stmt->bind_param("isssd", $user_id, $transaction_date, $category, $description, $amount);

    // 쿼리 실행 및 응답 처리
    if ($stmt->execute()) {
        // 실행 성공 시 JSON 형식의 성공 응답 반환
        echo json_encode(['success' => true]);
    } else {
        // 실행 실패 시 JSON 형식의 오류 메시지 반환
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close(); // Prepared statement 종료
} else {
    // POST 요청이 아닌 경우 오류 메시지 반환
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close(); // 데이터베이스 연결 종료
?>

<?php
// HTTP 응답 헤더 설정
header("Access-Control-Allow-Origin: *"); // 모든 도메인에서 CORS 요청 허용
header("Access-Control-Allow-Methods: GET"); // 허용된 HTTP 메서드를 GET으로 제한
header("Content-Type: application/json; charset=utf-8"); // 응답 콘텐츠 유형을 JSON 형식으로 설정

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

// GET 요청 처리 및 'month' 파라미터 확인
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['month'])) {
    $month = $_GET['month']; // GET 요청에서 'month' 값을 가져옴

    // 지정된 월의 거래 데이터를 가져오는 SQL 쿼리 (날짜 기준 정렬)
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE DATE_FORMAT(transaction_date, '%Y-%m') = ? ORDER BY transaction_date ASC");
    $stmt->bind_param("s", $month); // 'month' 값을 문자열로 바인딩
    $stmt->execute(); // SQL 쿼리 실행
    $result = $stmt->get_result(); // 결과 가져오기

    $transactions = []; // 결과를 저장할 배열
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row; // 각 행을 배열에 추가
    }

    echo json_encode($transactions); // 결과를 JSON 형식으로 반환
    $stmt->close(); // Prepared Statement 닫기
} else {
    // GET 요청이 아니거나 'month' 파라미터가 없는 경우 오류 메시지 반환
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close(); // MySQL 연결 닫기
?>

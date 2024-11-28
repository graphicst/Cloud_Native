<?php
// CORS 설정: 모든 출처에서의 접근을 허용
header("Access-Control-Allow-Origin: *");
// HTTP 요청 메서드 허용: POST 요청만 허용
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

// 연결 실패 시 에러 메시지를 JSON 형식으로 반환 후 종료
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// HTTP 요청이 POST인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 데이터에서 사용자 이름과 비밀번호를 가져옴. 없을 경우 null로 설정
    $username = $_POST['username'] ?? null; // 사용자 이름
    $password = $_POST['password'] ?? null; // 비밀번호

    // 필수 필드 검증: 사용자 이름과 비밀번호가 입력되지 않았으면 에러 반환
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']); // 오류 메시지 출력
        $conn->close(); // 데이터베이스 연결 종료
        exit; // 스크립트 종료
    }

    // SQL 쿼리 준비: 사용자 이름에 해당하는 ID와 해시된 비밀번호를 조회
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // 사용자 이름을 쿼리에 바인딩
    $stmt->execute(); // SQL 실행
    $result = $stmt->get_result(); // 실행 결과 가져오기

    // 사용자가 존재하면 비밀번호 검증
    if ($row = $result->fetch_assoc()) {
        // 입력된 비밀번호를 해시된 비밀번호와 비교
        if (password_verify($password, $row['password'])) {
            // 비밀번호 일치: 성공 메시지와 사용자 ID 반환
            echo json_encode(['success' => true, 'user_id' => $row['id']]);
        } else {
            // 비밀번호 불일치: 오류 메시지 반환
            echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
        }
    } else {
        // 사용자가 존재하지 않으면 오류 메시지 반환
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }

    // Prepared statement 종료
    $stmt->close();
} else {
    // POST 요청이 아닌 경우 오류 메시지 반환
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

// 데이터베이스 연결 종료
$conn->close();
?>

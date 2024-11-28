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

// 데이터베이스 연결 확인
if ($conn->connect_error) {
    // 연결 실패 시 에러 메시지를 로그에 기록하고 JSON 형식으로 오류 반환 후 종료
    error_log("Database connection failed: " . $conn->connect_error);
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

// HTTP 요청 메서드가 POST인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 데이터에서 사용자 이름과 비밀번호를 가져옴. 없을 경우 null로 설정
    $username = $_POST['username'] ?? null; // 사용자 이름
    $password = $_POST['password'] ?? null; // 비밀번호

    // 필수 입력값 확인: 사용자 이름과 비밀번호가 입력되지 않았으면 에러 반환
    if (!$username || !$password) {
        // 누락된 필드 정보를 로그에 기록
        error_log("Missing fields: username=$username, password=$password");
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        $conn->close(); // 데이터베이스 연결 종료
        exit; // 스크립트 종료
    }

    // 비밀번호 해싱 (BCRYPT 알고리즘 사용)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    if (!$hashed_password) {
        // 비밀번호 해싱 실패 시 로그 기록 및 에러 반환
        error_log("Password hashing failed");
        echo json_encode(['success' => false, 'error' => 'Password hashing failed']);
        $conn->close(); // 데이터베이스 연결 종료
        exit; // 스크립트 종료
    }

    // 사용자 중복 확인: 동일한 사용자 이름이 이미 등록되었는지 확인
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // 사용자 이름을 쿼리에 바인딩
    $stmt->execute(); // SQL 실행
    $result = $stmt->get_result(); // 실행 결과 가져오기

    // 사용자 이름이 이미 존재하면 에러 반환
    if ($result->num_rows > 0) {
        error_log("Username already exists: $username"); // 로그 기록
        echo json_encode(['success' => false, 'error' => 'Username already exists']);
        $stmt->close(); // Prepared statement 종료
        $conn->close(); // 데이터베이스 연결 종료
        exit; // 스크립트 종료
    }
    $stmt->close(); // 중복 확인을 위한 statement 종료

    // 사용자 등록: 사용자 이름과 해시된 비밀번호를 데이터베이스에 삽입
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password); // 사용자 이름과 해시된 비밀번호 바인딩

    // 삽입 성공 여부 확인
    if ($stmt->execute()) {
        // 성공 시 JSON 형식으로 성공 응답 반환
        echo json_encode(['success' => true]);
    } else {
        // 실패 시 로그 기록 및 에러 메시지 반환
        error_log("Insert failed: " . $stmt->error);
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close(); // Prepared statement 종료
} else {
    // POST 요청이 아닌 경우 오류 메시지 반환
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

// 데이터베이스 연결 종료
$conn->close();
?>

// Constants
const API_URL_ADD = "http://192.168.217.128:8080/transaction-add.php"; // 거래 추가 API URL
const API_URL_LIST = "http://192.168.217.128:8080/transaction-list.php"; // 거래 목록 API URL

// Global variables
let currentMonth = "2024-11"; // 기본적으로 표시할 달 (현재 달)

// Load transactions for the specified month
function loadTransactions(month) {
    const user_id = localStorage.getItem("user_id"); // 사용자 ID 확인

    if (!user_id) {
        console.log("User is not logged in. Transactions will not be loaded.");
        $("#transactionTableBody").empty(); // 테이블 내용 초기화
        $("#totalAmount").text("0"); // 총 금액 초기화
        return; // 함수 종료
    }

    console.log(`Loading transactions for user ${user_id} and month: ${month}`);
    // AJAX GET 요청을 통해 특정 월의 거래 기록을 가져옴
    $.get(`${API_URL_LIST}?user_id=${user_id}&month=${month}`, function (data) {
        console.log("Data received:", data);

        $("#transactionTableBody").empty(); // 테이블 내용 초기화

        let totalAmount = 0; // 총 금액 초기화
        data.forEach(transaction => {
            const row = `<tr>
                <td>${transaction.transaction_date}</td>
                <td>${transaction.category}</td>
                <td>${transaction.description}</td>
                <td>${transaction.amount}</td>
                <td>
                    <button class="delete-btn" data-id="${transaction.id}">Delete</button>
                </td>
            </tr>`;
            $("#transactionTableBody").append(row); // 테이블에 행 추가

            totalAmount += parseFloat(transaction.amount); // 총 금액 계산
        });

        $("#totalAmount").text(totalAmount.toLocaleString()); // 총 금액 표시
    }).fail(function (error) {
        console.error("Failed to load transactions:", error);
        alert("기록을 불러오는데 실패했습니다. 다시 시도해주세요!");
    });
}


// Delete transaction
$(document).on("click", ".delete-btn", function () {
    const transactionId = $(this).data("id"); // 삭제할 거래 ID 가져오기
    if (confirm("선택하신 기록을 삭제하시겠습니까?")) {
        // AJAX POST 요청으로 삭제 요청
        $.ajax({
            url: `${API_URL_ADD.replace("transaction-add.php", "transaction-delete.php")}`, // 삭제 API URL
            type: "POST",
            data: { id: transactionId }, // 삭제할 거래 ID 전달
            success: function (response) {
                console.log("Delete Response:", response);
                if (response.success) {
                    alert("성공적으로 삭제되었습니다!");
                    loadTransactions(currentMonth); // 테이블 갱신
                } else {
                    alert(`삭제에 실패했습니다.: ${response.error}`);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr, status, error);
                alert("삭제에 실패했습니다. 다시 시도해주세요!");
            },
        });
    }
});

// Add Transaction 이벤트 리스너
$("#transaction-form").on("submit", function (e) {
    e.preventDefault();

    const transactionDate = $("input[name='transaction_date']").val();
    const category = $("input[name='category']").val();
    const description = $("input[name='description']").val();
    const amount = $("input[name='amount']").val();
    const user_id = localStorage.getItem("user_id"); // 사용자 ID 가져오기

    if (!user_id || !transactionDate || !category || !description || !amount) {
        alert("모든 필드를 채워주세요.");
        return;
    }

    // AJAX POST 요청으로 거래 추가
    $.post(API_URL_ADD, {
        user_id, // 사용자 ID 전달
        transaction_date: transactionDate,
        category,
        description,
        amount: parseFloat(amount),
    }, function (response) {
        if (response.success) {
            alert("정상적으로 저장되었습니다!");
            loadTransactions(currentMonth);
        } else {
            alert(`저장에 실패했습니다.: ${response.error}`);
        }
    }).fail(function (error) {
        console.error("Error:", error);
        alert("서버와의 통신에 문제가 발생했습니다.");
    });
});



// Update the displayed month
function updateMonthDisplay() {
    $("#current-month").text(currentMonth); // 현재 표시 중인 월 업데이트
    loadTransactions(currentMonth); // 해당 월의 거래 기록 갱신
}

// Navigate to the previous month
$("#prevMonthBtn").on("click", function () {
    // 이전 월로 이동
    const [year, month] = currentMonth.split("-").map(Number);
    const newDate = new Date(year, month - 2); // 현재 월에서 한 달 전으로 이동
    currentMonth = `${newDate.getFullYear()}-${String(newDate.getMonth() + 1).padStart(2, "0")}`; // 월 업데이트
    updateMonthDisplay();
});

// Navigate to the next month
$("#nextMonthBtn").on("click", function () {
    // 다음 월로 이동
    const [year, month] = currentMonth.split("-").map(Number);
    const newDate = new Date(year, month); // 현재 월에서 한 달 후로 이동
    currentMonth = `${newDate.getFullYear()}-${String(newDate.getMonth() + 1).padStart(2, "0")}`; // 월 업데이트
    updateMonthDisplay();
});

// Initial load
$(document).ready(function () {
    updateMonthDisplay(); // 페이지 로드 시 현재 월 거래 기록 불러오기
});


const API_URL_REGISTER = "http://192.168.217.128:8080/register.php";
const API_URL_LOGIN = "http://192.168.217.128:8080/login.php";

// 회원가입
function register() {
    const username = $("#register-username").val();
    const password = $("#register-password").val();

    if (!username || !password) {
        alert("모든 필드를 채워주세요.");
        return;
    }

    $.post(API_URL_REGISTER, { username, password }, function (response) {
        if (response.success) {
            alert("회원가입 성공!");
            $("#register-form").hide();
            $("#login-form").show();
        } else {
            alert(`회원가입 실패: ${response.error}`);
        }
    });
}

// 로그인
function login() {
    const username = $("#login-username").val();
    const password = $("#login-password").val();

    if (!username || !password) {
        alert("모든 필드를 채워주세요.");
        return;
    }

    // 로그인 API 호출
    $.post(API_URL_LOGIN, { username, password }, function (response) {
        console.log("Login API response:", response); // 디버깅용

        if (response.success) {
            // 사용자 정보를 localStorage에 저장
            localStorage.setItem("user_id", response.user_id);
            localStorage.setItem("username", username);

            // 로그인 UI 업데이트
            updateUIOnLogin();

            alert("로그인 성공!");
        } else {
            alert(`로그인 실패: ${response.error}`);
        }
    }).fail(function (error) {
        console.error("Login API error:", error);
        alert("서버와 통신 중 오류가 발생했습니다.");
    });
}

// 로그인 상태에 따라 UI 업데이트
function updateUIOnLogin() {
    const username = localStorage.getItem("username");

    if (username) {
        // 로그인된 상태
        $("#user-name").text(username); // 사용자 이름 표시
        $("#user-info").show(); // 사용자 정보 표시
        $("#login-form").hide(); // 로그인 폼 숨기기
        $("#transaction-form").show(); // 거래 입력 폼 표시
        loadTransactions(currentMonth); // 거래 데이터 로드
    } else {
        // 로그인되지 않은 상태
        $("#user-info").hide(); // 사용자 정보 숨기기
        $("#login-form").show(); // 로그인 폼 표시
        $("#transaction-form").hide(); // 거래 입력 폼 숨기기
        $("#transactionTableBody").empty(); // 거래 목록 초기화
        $("#totalAmount").text("0"); // 총 금액 초기화
    }
}


// 로그아웃
function logout() {
    // localStorage에서 사용자 정보 제거
    localStorage.removeItem("user_id");
    localStorage.removeItem("username");

    // UI 초기화
    $("#user-info").hide();
    $("#login-form").show();
    $("#transaction-form").hide();
    $("#transactionTableBody").empty(); // 테이블 내용 초기화
}


// 로그인 폼 보이기
function showLoginForm() {
    $("#register-form").hide(); // 회원가입 폼 숨기기
    $("#login-form").show(); // 로그인 폼 보이기
}

// 회원가입 폼 보이기
function showRegisterForm() {
    $("#login-form").hide(); // 로그인 폼 숨기기
    $("#register-form").show(); // 회원가입 폼 보이기
}

// 회원가입 요청
function register() {
    const username = $("#register-username").val();
    const password = $("#register-password").val();
    const confirmPassword = $("#register-confirm-password").val();

    // 비밀번호 확인
    if (password !== confirmPassword) {
        alert("비밀번호가 일치하지 않습니다.");
        return;
    }

    if (!username || !password) {
        alert("모든 필드를 입력해주세요.");
        return;
    }

    // 회원가입 API 호출
    $.post(API_URL_REGISTER, { username, password }, function (response) {
        console.log("Register response:", response); // 응답 디버깅
        if (response.success) {
            alert("회원가입 성공!");
            showLoginForm();
        } else {
            alert(`회원가입 실패: ${response.error}`);
        }
    }).fail(function (error) {
        console.error("Register API error:", error);
        alert("서버와 통신 중 오류가 발생했습니다.");
    });
}

// 페이지 로드 시 로그인 상태 확인
$(document).ready(function () {
    const username = localStorage.getItem("username");

    if (username) {
        updateUIOnLogin(); // 로그인된 상태라면 UI 업데이트
    } else {
        $("#login-form").show(); // 로그인 폼 표시
        $("#transaction-form").hide(); // transaction 폼 숨기기
    }
});


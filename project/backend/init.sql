CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 사용자와 연결
    transaction_date DATE NOT NULL,
    description VARCHAR(255),
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- 비밀번호는 해시화
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
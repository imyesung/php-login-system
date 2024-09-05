<?php
session_start();
require 'config.php';  // 데이터베이스 연결 설정

// 세션에서 실패 횟수 추적
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// 폼 제출 시 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 사용자 조회
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 사용자 존재 여부 및 비밀번호 검증
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['login_attempts'] = 0;  // 로그인 성공 시 실패 횟수 초기화
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['login_attempts'] += 1;  // 실패 시 횟수 증가
        $error_message = "잘못된 이메일 또는 비밀번호입니다.";

        // 3회 실패 시 데이터베이스에 기록
        if ($_SESSION['login_attempts'] >= 3) {
            $stmt = $pdo->prepare("INSERT INTO login_failures (email, failed_at) VALUES (?, NOW())");
            $stmt->execute([$email]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Please Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #172b4d;
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #172b4d;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .signup-message {
            text-align: center;
            margin-top: 20px;
            color: #172b4d;
        }

        .signup-message a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-message a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php
    // 로그인 실패 시 오류 메시지 출력
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>

    <!-- 로그인 폼 -->
    <form action="index.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <!-- 회원가입 메시지 -->
    <div class="signup-message">
        <p>계정이 없으신가요? <a href="signup.php">회원가입</a>을 진행해 주세요!</p>
    </div>
</div>

</body>
</html>

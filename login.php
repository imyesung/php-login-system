<?php
require 'config.php';  // 데이터베이스 연결 설정
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 사용자 정보 조회
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 사용자가 존재하고 비밀번호가 일치하는지 확인
    if ($user && password_verify($password, $user['password'])) {
        // 로그인 성공 시 세션 설정
        $_SESSION['username'] = $user['username'];  // 닉네임 저장
        $_SESSION['email'] = $user['email'];        // 이메일 저장

        // 대시보드로 리다이렉트
        header("Location: dashboard.php");
        exit();
    } else {
        echo "잘못된 이메일 또는 비밀번호입니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #0052cc;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #dfe1e6;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;  /* 파란색 버튼 */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;  /* 어두운 파란색 */
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    
    <!-- 로그인 폼 -->
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>

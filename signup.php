<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <h2>Signup</h2>
    <form action="signup.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 데이터베이스 연결
        require 'config.php';

        // 입력받은 값 저장
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호 해싱

        // SQL 쿼리 실행 (사용자 추가)
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$username, $email, $password]);
            echo "<p>Signup successful! You can now log in.</p>";
        } catch (PDOException $e) {
            // 중복 이메일 등의 문제 처리
            if ($e->getCode() == 23000) {
                echo "<p>Email already exists. Please use a different email.</p>";
            } else {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    ?>
</body>
</html>

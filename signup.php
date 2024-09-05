<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        /* 전체 페이지 레이아웃 설정 */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* 카드 형식의 중앙화된 레이아웃 */
        .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* 제목 스타일 */
        h2 {
            text-align: center;
            color: #172b4d;
            margin-bottom: 24px;
        }

        /* 라벨 스타일 */
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #172b4d;
        }

        /* 입력 필드 스타일 */
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #dfe1e6;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* 제출 버튼 스타일 */
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #0052cc;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        /* 버튼 호버 스타일 */
        input[type="submit"]:hover {
            background-color: #0747a6;
        }

        /* 에러 메시지 스타일 */
        .error {
            color: red;
            margin-bottom: 20px;
        }

        /* 성공 메시지 스타일 */
        .success {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>Signup</h2>

        <?php
        // 회원가입 성공 또는 오류 메시지 출력
        if (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        } elseif (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>

        <!-- 회원가입 폼 -->
        <form action="signup.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Signup">
        </form>
    </div>

</body>
</html>

<?php
// 세션 시작
session_start();

// 로그인하지 않은 사용자는 접근할 수 없도록 설정
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// 데이터베이스 연결 파일 포함
require 'config.php';

// 글 작성 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    $message = $_POST['message'];
    $username = $_SESSION['username'];

    // 새 글 저장 (DB에 삽입)
    $stmt = $pdo->prepare("INSERT INTO guestbook (username, message) VALUES (?, ?)");
    $stmt->execute([$username, $message]);

    // 페이지 새로고침 (중복 제출 방지)
    header("Location: dashboard.php");
    exit();
}

// 글 수정 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_message'])) {
    $message = $_POST['message'];
    $message_id = $_POST['message_id'];

    // 글 수정
    $stmt = $pdo->prepare("UPDATE guestbook SET message = ? WHERE id = ? AND username = ?");
    $stmt->execute([$message, $message_id, $_SESSION['username']]);

    // 페이지 새로고침
    header("Location: dashboard.php");
    exit();
}

// 글 삭제 처리
if (isset($_GET['delete_id'])) {
    $message_id = $_GET['delete_id'];

    // 글 삭제 (본인의 글만 삭제 가능)
    $stmt = $pdo->prepare("DELETE FROM guestbook WHERE id = ? AND username = ?");
    $stmt->execute([$message_id, $_SESSION['username']]);

    // 페이지 새로고침
    header("Location: dashboard.php");
    exit();
}

// 저장된 글 불러오기
$stmt = $pdo->prepare("SELECT * FROM guestbook ORDER BY created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Guestbook</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #172b4d;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout a {
            color: #0052cc;
            text-decoration: none;
            font-weight: bold;
        }

        form {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #dfe1e6;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #0052cc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0747a6;
        }

        .message {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .message-header {
            font-weight: bold;
            color: #0052cc;
            margin-bottom: 5px;
        }

        .message-body {
            color: #333;
        }

        .message-time {
            font-size: 12px;
            color: #999;
        }

        .message-actions {
            margin-top: 10px;
        }

        .edit-form {
            margin-top: 10px;
            display: none;
        }
    </style>
    <script>
        function showEditForm(id) {
            var editForm = document.getElementById('edit-form-' + id);
            var deleteLink = document.getElementById('delete-link-' + id);
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
                deleteLink.style.display = 'inline';
            } else {
                editForm.style.display = 'none';
                deleteLink.style.display = 'none';
            }
        }
    </script>
</head>
<body>

    <div class="container">
        <div class="logout">
           <a href="logout.php">로그아웃</a> 
        </div>

        <h2>Guestbook</h2>

        <!-- 글 작성 폼 -->
        <form action="dashboard.php" method="POST">
            <textarea name="message" placeholder="Leave a message..." required></textarea>
            <input type="submit" name="submit_message" value="Post Message">
        </form>

        <!-- 저장된 글 목록 표시 -->
        <?php foreach ($messages as $message): ?>
            <div class="message">
                <div class="message-header">
                    <?php echo htmlspecialchars($message['username']); ?>
                    <span class="message-time"><?php echo $message['created_at']; ?></span>
                    <?php if ($message['updated_at'] != $message['created_at']): ?>
                        <span class="message-time">(edited)</span>
                    <?php endif; ?>
                </div>
                <div class="message-body">
                    <?php echo htmlspecialchars($message['message']); ?>
                </div>

                <!-- 본인 글일 경우만 수정 및 삭제 버튼 표시 -->
                <?php if ($message['username'] === $_SESSION['username']): ?>
                    <div class="message-actions">
                        <button onclick="showEditForm(<?php echo $message['id']; ?>)">Edit</button>
                        <a href="javascript:void(0);" id="delete-link-<?php echo $message['id']; ?>" style="display:none;" onclick="if(confirm('Are you sure you want to delete this message?')) { window.location.href='dashboard.php?delete_id=<?php echo $message['id']; ?>'; }">Delete</a>
                        <form action="dashboard.php" method="POST" id="edit-form-<?php echo $message['id']; ?>" class="edit-form">
                            <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                            <textarea name="message" required><?php echo htmlspecialchars($message['message']); ?></textarea>
                            <input type="submit" name="edit_message" value="Save">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
